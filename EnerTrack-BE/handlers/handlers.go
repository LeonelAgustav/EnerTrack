package handlers

import (
	"context"
	"database/sql"
	"encoding/json"
	"fmt"
	"log"
	"math"
	"net/http"
	"os"
	"strconv"
	"strings"
	"time"

	"EnerTrack-BE/middleware"
	"EnerTrack-BE/models"

	"github.com/google/generative-ai-go/genai"
	"github.com/google/uuid"
	"golang.org/x/crypto/bcrypt"
	"google.golang.org/api/option"
)

type Handler struct {
	DB     *sql.DB
	Client *genai.Client
	Model  *genai.GenerativeModel
}

type UserProfile struct {
	ID        uint   `json:"id"`
	FullName  string `json:"full_name"`
	Username  string `json:"username"`
	Email     string `json:"email"`
	CreatedAt string `json:"created_at"`
	UpdatedAt string `json:"updated_at"`
}

func NewHandler(db *sql.DB) *Handler {
	ctx := context.Background()

	// Get API key from environment variable
	apiKey := os.Getenv("GEMINI_API_KEY")
	if apiKey == "" {
		log.Printf("Warning: GEMINI_API_KEY environment variable is not set")
		return &Handler{DB: db}
	}

	client, err := genai.NewClient(ctx, option.WithAPIKey(apiKey))
	if err != nil {
		log.Printf("Failed to create AI client: %v", err)
		return &Handler{DB: db}
	}

	model := client.GenerativeModel("gemini-pro")
	return &Handler{
		DB:     db,
		Client: client,
		Model:  model,
	}
}

func (h *Handler) Register(w http.ResponseWriter, r *http.Request) {
	var user struct {
		Fullname string `json:"fullname"`
		Username string `json:"username"`
		Email    string `json:"email"`
		Password string `json:"password"`
	}
	if err := json.NewDecoder(r.Body).Decode(&user); err != nil {
		log.Printf("❌ Register failed - Invalid request body: %v", err)
		http.Error(w, "Invalid request body", http.StatusBadRequest)
		return
	}

	// Hash the password
	hashedPassword, err := bcrypt.GenerateFromPassword([]byte(user.Password), bcrypt.DefaultCost)
	if err != nil {
		log.Printf("❌ Register failed - Failed to hash password: %v", err)
		http.Error(w, "Registration failed", http.StatusInternalServerError)
		return
	}

	_, err = h.DB.Exec("INSERT INTO users (fullname, username, email, password) VALUES (?, ?, ?, ?)",
		user.Fullname, user.Username, user.Email, string(hashedPassword)) // Store hashed password
	if err != nil {
		log.Printf("❌ Register failed - Database error: %v", err)
		http.Error(w, "Registration failed", http.StatusInternalServerError)
		return
	}

	log.Printf("✅ User registered successfully - Email: %s, Username: %s", user.Email, user.Username)
	w.WriteHeader(http.StatusCreated)
	json.NewEncoder(w).Encode(map[string]interface{}{"message": "User registered successfully", "success": true})
}

func (h *Handler) Login(w http.ResponseWriter, r *http.Request) {
	var creds struct {
		Email    string `json:"email"`
		Password string `json:"password"`
	}

	if err := json.NewDecoder(r.Body).Decode(&creds); err != nil {
		log.Printf("❌ Login failed - Invalid request body: %v", err)
		http.Error(w, "Invalid request body", http.StatusBadRequest)
		return
	}

	log.Printf("Attempting login for email: %s", creds.Email)

	var user models.User
	var storedHashedPassword string // Use string to store hashed password
	err := h.DB.QueryRow("SELECT user_id, email, password FROM users WHERE LOWER(TRIM(email)) = LOWER(TRIM(?)) ", creds.Email).Scan(&user.ID, &user.Email, &storedHashedPassword)
	if err != nil {
		if err == sql.ErrNoRows {
			log.Printf("❌ Login failed - User not found for email: %s", creds.Email)
			http.Error(w, "Invalid credentials", http.StatusUnauthorized)
			return
		}
		log.Printf("❌ Login failed - Database error: %v", err)
		http.Error(w, "Login failed due to server error", http.StatusInternalServerError)
		return
	}

	// Compare the provided password with the stored hashed password
	err = bcrypt.CompareHashAndPassword([]byte(storedHashedPassword), []byte(creds.Password))
	if err != nil {
		log.Printf("❌ Login failed - Invalid password for email: %s", creds.Email)
		http.Error(w, "Invalid credentials", http.StatusUnauthorized)
		return
	}

	token, err := middleware.GenerateJWT(user.ID, user.Email)
	if err != nil {
		log.Printf("❌ Login failed - Token generation error: %v", err)
		http.Error(w, "Failed to generate token", http.StatusInternalServerError)
		return
	}

	log.Printf("✅ JWT Token generated: %s", token)

	log.Printf("✅ User logged in successfully - User ID: %d, Email: %s", user.ID, creds.Email)
	json.NewEncoder(w).Encode(map[string]interface{}{
		"token":   token,
		"user_id": user.ID,
		"email":   user.Email,
	})
}

func (h *Handler) SubmitDevice(w http.ResponseWriter, r *http.Request) {
	claims, err := middleware.GetClaimsFromContext(r)
	if err != nil {
		log.Printf("❌ Submit device failed - Auth error: %v", err)
		http.Error(w, "Unauthorized", http.StatusUnauthorized)
		return
	}

	var inputData struct {
		BillingType string `json:"billing_type"`
		Electricity struct {
			Amount float64 `json:"amount,omitempty"`
			Kwh    float64 `json:"kwh,omitempty"`
		} `json:"electricity"`
		Devices []models.Device `json:"devices"`
	}

	if err := json.NewDecoder(r.Body).Decode(&inputData); err != nil {
		log.Printf("❌ Submit device failed - Invalid request body: %v", err)
		http.Error(w, "Invalid request body", http.StatusBadRequest)
		return
	}

	log.Printf("Received submit request - Billing Type: %s, Devices: %d", inputData.BillingType, len(inputData.Devices))

	if inputData.BillingType == "" {
		log.Printf("❌ Submit device failed - Billing type is required")
		http.Error(w, "Billing type is required", http.StatusBadRequest)
		return
	}

	if len(inputData.Devices) == 0 {
		log.Printf("❌ Submit device failed - No devices provided")
		http.Error(w, "No devices provided", http.StatusBadRequest)
		return
	}

	idSubmit := uuid.New().String()
	tanggal := time.Now().Format("2006-01-02")

	tx, err := h.DB.Begin()
	if err != nil {
		log.Printf("❌ Submit device failed - Database transaction error: %v", err)
		http.Error(w, "Database error", http.StatusInternalServerError)
		return
	}
	defer tx.Rollback()

	var totalPowerWh float64
	var firstDeviceRiwayatID int // Declare firstDeviceRiwayatID here

	for i, device := range inputData.Devices {
		if device.Name == "" || device.Brand == "" || device.Power <= 0 || device.Duration <= 0 || device.Quantity <= 0 {
			log.Printf("❌ Submit device failed - Invalid device data: %+v", device)
			http.Error(w, "Invalid device data (missing name, brand, power, duration, or quantity)", http.StatusBadRequest)
			return
		}

		device.Jenis_Pembayaran = inputData.BillingType
		if inputData.BillingType == "token" {
			device.Besar_Listrik = fmt.Sprintf("%.2f kWh", inputData.Electricity.Kwh)
		} else {
			device.Besar_Listrik = fmt.Sprintf("%.2f VA", inputData.Electricity.Kwh)
		}

		devicePowerWh := float64(device.Power) * float64(device.Quantity) * float64(device.Duration) // Include quantity in Wh calculation
		totalPowerWh += devicePowerWh

		// Calculate usage and cost per device for direct storage in riwayat_perangkat
		deviceDailyKWh := (float64(device.Power) * float64(device.Duration) * float64(device.Quantity)) / 1000.0
		deviceMonthlyKWh := deviceDailyKWh * 30

		// Get tariff rate for this device's billing type (assuming it's consistent across devices for simplicity)
		// If billing type can vary per device, get this from device.Besar_Listrik and make getTariffRate accept it
		tariffRate := getTariffRate(device.Besar_Listrik)
		deviceMonthlyCost := deviceMonthlyKWh * tariffRate

		log.Printf("Device usage calculations - Daily: %.2f kWh, Weekly: %.2f kWh, Monthly: %.2f kWh, Monthly Cost: %.2f",
			deviceDailyKWh, deviceDailyKWh*7, deviceMonthlyKWh, deviceMonthlyCost)
		log.Printf("Attempting to insert device: %+v", device)
		log.Printf("Inserting: Name=%s, Brand=%s, Power=%d, Duration=%d, Quantity=%d, DailyKWh=%.2f, MonthlyKWh=%.2f, MonthlyCost=%.2f",
			device.Name, device.Brand, device.Power, device.Duration, device.Quantity, deviceDailyKWh, deviceMonthlyKWh, deviceMonthlyCost)
		result, err := tx.Exec(`
			INSERT INTO riwayat_perangkat 
			(id_submit, user_id, Jenis_Pembayaran, Besar_Listrik, nama_perangkat, category, merek, daya, durasi, quantity, tanggal_input, Weekly_Usage, Monthly_Usage, Monthly_cost, Daily_Usage) 
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
			idSubmit, claims.UserID, device.Jenis_Pembayaran, device.Besar_Listrik,
			device.Name, device.Category, device.Brand, device.Power, device.Duration, device.Quantity, tanggal,
			deviceDailyKWh*7, // Approximate weekly usage
			deviceMonthlyKWh,
			deviceMonthlyCost,
			deviceDailyKWh, // Add daily usage
		)

		if err != nil {
			log.Printf("❌ Submit device failed - Database insert error: %v", err)
			http.Error(w, "Failed to save device data", http.StatusInternalServerError)
			return
		}

		// Capture the ID of the first inserted device to use as riwayatID for analysis
		if i == 0 { // Only capture for the first device in the batch
			lastID, err := result.LastInsertId()
			if err != nil {
				log.Printf("❌ Submit device failed - Failed to get last insert ID: %v", err)
				http.Error(w, "Failed to get device ID", http.StatusInternalServerError)
				return
			}
			firstDeviceRiwayatID = int(lastID)
			log.Printf("First device inserted, riwayat_id: %d", firstDeviceRiwayatID)
		}
	}

	// Calculate overall monthly kWh and estimated cost for the entire submission
	totalPowerKWh := totalPowerWh / 1000.0
	monthlyKWh := totalPowerKWh * 30

	// Get tariff rate (assuming it's consistent for all devices in a single submission)
	besarListrik := inputData.Devices[0].Besar_Listrik
	tariffRate := getTariffRate(besarListrik)
	estimatedMonthlyCost := monthlyKWh * tariffRate

	// Commit transaction
	if err := tx.Commit(); err != nil {
		log.Printf("❌ Submit device failed - Transaction commit error: %v", err)
		http.Error(w, "Failed to save device data", http.StatusInternalServerError)
		return
	}

	// Get usage stats for response
	usageStats, err := h.calculateUsageStats(claims.UserID)
	if err != nil {
		log.Printf("❌ Submit device failed - Calculate usage stats error: %v", err)
		// Continue even if stats calculation fails
		usageStats = models.UsageStats{}
	}

	log.Printf("✅ Device data submitted successfully - User ID: %d, Submit ID: %s", claims.UserID, idSubmit)

	// Prepare JSON response
	response := map[string]interface{}{
		"success":       true,
		"message":       "Device data submitted successfully",
		"total_usage":   totalPowerKWh,
		"monthly_cost":  formatRupiah(estimatedMonthlyCost),
		"usage_stats":   usageStats,
		"id_submit":     idSubmit,
		"besar_listrik": besarListrik,
		"riwayat_id":    firstDeviceRiwayatID,
	}

	w.Header().Set("Content-Type", "application/json")
	if err := json.NewEncoder(w).Encode(response); err != nil {
		log.Printf("❌ Submit device failed - Response encoding error: %v", err)
		http.Error(w, "Failed to encode response", http.StatusInternalServerError)
		return
	}
}

func (h *Handler) GetBrands(w http.ResponseWriter, r *http.Request) {
	rows, err := h.DB.Query("SELECT id, nama_merek FROM merek ORDER BY nama_merek ASC")
	if err != nil {
		log.Printf("❌ Get brands failed - Database error: %v", err)
		http.Error(w, "Failed to fetch brands", http.StatusInternalServerError)
		return
	}
	defer rows.Close()

	var brands []models.Brand
	for rows.Next() {
		var brand models.Brand
		if err := rows.Scan(&brand.ID, &brand.Name); err != nil {
			log.Printf("❌ Get brands failed - Scan error: %v", err)
			http.Error(w, "Failed to scan brand data", http.StatusInternalServerError)
			return
		}
		brands = append(brands, brand)
	}

	log.Printf("✅ Brands fetched successfully - Count: %d", len(brands))
	json.NewEncoder(w).Encode(brands)
}

func (h *Handler) Analyze(w http.ResponseWriter, r *http.Request) {
	// Get riwayat_id from query parameter
	riwayatID := r.URL.Query().Get("riwayat_id")
	if riwayatID == "" {
		http.Error(w, "riwayat_id is required", http.StatusBadRequest)
		return
	}

	// Get installed_power_va from query parameter
	installedPowerVA := r.URL.Query().Get("installed_power_va")
	if installedPowerVA == "" {
		http.Error(w, "installed_power_va is required", http.StatusBadRequest)
		return
	}

	claims, err := middleware.GetClaimsFromContext(r)
	if err != nil {
		log.Printf("❌ Analysis failed - Auth error: %v", err)
		http.Error(w, err.Error(), http.StatusUnauthorized)
		return
	}

	// Get devices from database using the id_submit associated with riwayatID
	var actualIDSubmit string
	err = h.DB.QueryRow(`
		SELECT id_submit 
		FROM riwayat_perangkat 
		WHERE id = ? AND user_id = ?`, riwayatID, claims.UserID).Scan(&actualIDSubmit)
	if err != nil {
		if err == sql.ErrNoRows {
			log.Printf("Error: No riwayat_id found for user %d and riwayat_id %s", claims.UserID, riwayatID)
			http.Error(w, "No device data found for analysis", http.StatusBadRequest)
			return
		}
		log.Printf("Error querying id_submit from riwayat_perangkat: %v", err)
		http.Error(w, "Failed to get device submission ID", http.StatusInternalServerError)
		return
	}

	rows, err := h.DB.Query(`
		SELECT nama_perangkat, category, merek, daya, durasi, quantity, Weekly_Usage, Monthly_Usage, Monthly_cost 
		FROM riwayat_perangkat 
		WHERE id_submit = ? AND user_id = ?`, actualIDSubmit, claims.UserID)
	if err != nil {
		log.Printf("Error querying devices: %v", err)
		http.Error(w, "Failed to get devices", http.StatusInternalServerError)
		return
	}
	defer rows.Close()

	var devices []models.Device
	var totalPowerWh float64
	for rows.Next() {
		var device models.Device
		err := rows.Scan(&device.Name, &device.Category, &device.Brand, &device.Power, &device.Duration,
			&device.Quantity, &device.Weekly_Usage, &device.Monthly_Usage, &device.Monthly_Cost)
		if err != nil {
			log.Printf("Error scanning device row: %v", err)
			continue
		}
		devices = append(devices, device)
		totalPowerWh += float64(device.Power) * float64(device.Duration) * float64(device.Quantity)
	}

	log.Printf("Devices retrieved from DB: %+v", devices)

	// Calculate total simultaneous power usage
	totalSimultaneousPower := totalPowerWh

	// Build AI prompt with installed power VA
	prompt := fmt.Sprintf(`Anda adalah seorang analis energi yang membantu pengguna memahami dan menghemat penggunaan listrik di rumah.

Berikan analisis singkat tentang konsumsi listrik bulanan untuk setiap perangkat elektronik yang tercantum, konversikan semua hasilnya ke dalam Kilowatt-hour (kWh).

Hitung juga total daya listrik (Watt) yang terpakai secara simultan oleh semua perangkat yang disebutkan (asumsikan semua perangkat bisa menyala bersamaan), lalu bandingkan dengan daya listrik terpasang bangunan. Nyatakan apakah penggunaan listrik bangunan Anda melebihi kapasitas atau masih memiliki sisa.

Untuk kulkas yang beroperasi 24 jam, tekankan bahwa efisiensi adalah kunci penghematan, bukan durasi penggunaan.

Setelah itu, identifikasi perangkat mana yang paling boros berdasarkan data konsumsi kWh, dan berikan tiga saran singkat yang relevan untuk penghematan listrik, termasuk tips spesifik untuk kulkas.

Format respons harus berupa poin-poin singkat dan langsung pada hasilnya, tanpa header seperti "Analisis Penggunaan Listrik" atau "Estimasi Perangkat Paling Boros".

Berikut adalah data yang akan dianalisis:

**Daya listrik terpasang bangunan:** %s VA

**Data Perangkat:**
%s

Gunakan rumus untuk konsumsi bulanan (kWh): Konsumsi Listrik (kWh) = (Daya (Watt) * Waktu Pemakaian (Jam per Bulan)) / 1000
Gunakan rumus untuk total daya simultan (Watt): Total Daya Simultan (Watt) = Jumlah Daya (Watt) dari semua perangkat yang digunakan secara bersamaan.

Total daya listrik simultan yang terpakai adalah %.2f Watt.

CONTOH output yang diharapkan dari AI dengan data yang diberikan diatas:

Data Perangkat:
* Kulkas: X kWh
* AC: Y kWh
* TV: Z kWh
* Lampu (total): A kWh
* [Perangkat Lain]: B kWh

Total daya listrik simultan yang terpakai adalah [Total Daya Simultan dalam Watt] Watt.
Dengan daya terpasang bangunan %s VA (sekitar %s Watt), penggunaan listrik Anda **[melebihi kapasitas / masih memiliki sisa [Jumlah Sisa Watt] Watt]**

Perangkat paling boros (berdasarkan kWh bulanan) adalah **[Nama Perangkat Paling Boros]**, dengan total **[Jumlah kWh Perangkat Paling Boros] kWh**. Perlu dicatat bahwa konsumsi kulkas yang 24 jam lebih banyak bergantung pada efisiensi perangkat dan kebiasaan penggunaan, bukan semata durasi.

Saran penghematan:
1. Saran singkat 1 (termasuk tips kulkas jika relevan)
2. Saran singkat 2
3. Saran singkat 3

Rekomendasi Perangkat:
- Jika ada perangkat yang melebihi daya terpasang bangunan, maka rekomendasikan perangkat lain untuk menganti perangkat tersebut dengan perangkat yang lebih efisien(berdasarkan kwh).
- Kecuali jika perangkat tersebut adalah kulkas, maka tidak perlu mengganti perangkat tersebut dengan perangkat yang lebih efisien(berdasarkan kwh).
- Jika ada saran penghematan yang relevan, maka rekomendasikan perangkat lain untuk menganti perangkat tersebut dengan perangkat yang lebih efisien(berdasarkan kwh).

Format respons:
- Rekomendasikan pearngkat modern.
- Data Perangkat sesuai dengan data yang diberikan di awal.
- poin-poin singkat dan berikan Hasilnya saja tanpa header.
- convert ke Kwh semua.
- dalam bahasa indonesia.`,
		installedPowerVA,
		buildDeviceList(devices),
		totalSimultaneousPower,
		installedPowerVA,
		installedPowerVA)

	log.Printf("Prompt: %s", prompt)

	// Generate AI response
	var aiResponse string
	var analysisError error
	if h.Model == nil {
		analysisError = fmt.Errorf("AI model not initialized")
		aiResponse = "AI analysis is currently unavailable. Please try again later."
	} else {
		ctx := context.Background()
		resp, err := h.Model.GenerateContent(ctx, genai.Text(prompt))
		if err != nil {
			analysisError = err
			aiResponse = "Unable to generate AI analysis at this time. Please try again later."
		} else if resp == nil || len(resp.Candidates) == 0 {
			analysisError = fmt.Errorf("empty AI response")
			aiResponse = "Received empty response from AI service. Please try again later."
		} else {
			aiResponse = formatAIResponse(resp)
		}
	}

	// Calculate total power in kWh
	totalPowerKWh := totalSimultaneousPower / 1000.0

	// Calculate estimated monthly cost
	tariffRate := getTariffRate(installedPowerVA)
	estimatedMonthlyCost := totalPowerKWh * 30 * tariffRate // 30 days per month

	// Convert riwayatID to int
	riwayatIDInt, err := strconv.Atoi(riwayatID)
	if err != nil {
		log.Printf("❌ Failed to convert riwayatID to int: %v", err)
		http.Error(w, "Invalid riwayat_id format", http.StatusBadRequest)
		return
	}

	// Save to DB
	if err := h.SaveAnalysisToDB(claims.UserID, riwayatIDInt, int(totalSimultaneousPower), totalPowerKWh, aiResponse, estimatedMonthlyCost); err != nil {
		log.Printf("❌ Failed to save analysis to DB: %v", err)
	}

	// Prepare response
	response := map[string]interface{}{
		"success":  true,
		"analysis": aiResponse,
	}

	if analysisError != nil {
		response["analysis_error"] = analysisError.Error()
	}

	w.Header().Set("Content-Type", "application/json")
	if err := json.NewEncoder(w).Encode(response); err != nil {
		log.Printf("❌ Analysis failed - Response encoding error: %v", err)
		http.Error(w, "Failed to encode response", http.StatusInternalServerError)
		return
	}
}

func buildDeviceList(devices []models.Device) string {
	var sb strings.Builder
	for _, device := range devices {
		sb.WriteString(fmt.Sprintf("- %s (%s) (%d Watt) digunakan selama %d jam/hari\n", device.Name, device.Category, device.Power, device.Duration))
	}
	return sb.String()
}

func formatAIResponse(resp *genai.GenerateContentResponse) string {
	if resp == nil || len(resp.Candidates) == 0 || resp.Candidates[0].Content == nil {
		return "No response received from AI."
	}

	var aiResponse strings.Builder
	for _, part := range resp.Candidates[0].Content.Parts {
		if text, ok := part.(genai.Text); ok {
			cleanText := strings.ReplaceAll(string(text), "*", "")
			cleanText = strings.TrimSpace(cleanText)
			if cleanText != "" {
				aiResponse.WriteString(cleanText + "\n")
			}
		}
	}

	result := aiResponse.String()
	result = strings.TrimSpace(result)
	if result == "" {
		return "No valid response content received from AI."
	}
	return result
}

func (h *Handler) GetDailyStatistics(w http.ResponseWriter, r *http.Request) {
	claims, err := middleware.GetClaimsFromContext(r)
	if err != nil {
		log.Printf("❌ Get daily statistics failed - Auth error: %v", err)
		http.Error(w, err.Error(), http.StatusUnauthorized)
		return
	}

	// Cari hari Senin minggu ini
	now := time.Now()
	weekday := int(now.Weekday())
	if weekday == 0 { // Sunday
		weekday = 7
	}
	monday := now.AddDate(0, 0, -(weekday - 1))
	sunday := monday.AddDate(0, 0, 6)

	log.Printf("DEBUG: monday=%s, sunday=%s, now=%s", monday.Format("2006-01-02"), sunday.Format("2006-01-02"), now.Format("2006-01-02 15:04:05"))

	// Query data Senin-Minggu minggu ini
	rows, err := h.DB.Query(`
		SELECT tanggal_input, COALESCE(SUM(daily_usage), 0) as consumption
		FROM riwayat_perangkat
		WHERE user_id = ? AND tanggal_input >= ? AND tanggal_input <= ?
		GROUP BY tanggal_input
		ORDER BY tanggal_input ASC`,
		claims.UserID, monday.Format("2006-01-02"), sunday.Format("2006-01-02"))
	if err != nil {
		log.Printf("❌ Get daily statistics failed - Database error: %v", err)
		http.Error(w, "Failed to fetch statistics", http.StatusInternalServerError)
		return
	}
	defer rows.Close()

	// Map tanggal_input -> consumption
	consumptionMap := make(map[string]float64)
	for rows.Next() {
		var rawDate string
		var consumption float64
		if err := rows.Scan(&rawDate, &consumption); err != nil {
			log.Printf("❌ Get daily statistics failed - Scan error: %v", err)
			http.Error(w, "Failed to scan statistics data", http.StatusInternalServerError)
			return
		}
		consumptionMap[rawDate] = consumption
	}

	// Build 7 days result (selalu urut Senin-Minggu, atau urut 7 hari ke belakang)
	var stats []models.DailyStat
	for i := 0; i < 7; i++ {
		curr := monday.AddDate(0, 0, i)
		dateStr := curr.Format("2006-01-02")
		weekdayName := curr.Weekday().String() // English day name
		consumption := 0.0
		if val, ok := consumptionMap[dateStr]; ok {
			consumption = val
		}
		stats = append(stats, models.DailyStat{
			Date:        weekdayName,
			Consumption: consumption,
		})
	}

	log.Printf("✅ Daily statistics fetched successfully for user %d - Count: %d", claims.UserID, len(stats))
	json.NewEncoder(w).Encode(stats)
}

func (h *Handler) GetDeviceHistory(w http.ResponseWriter, r *http.Request) {
	claims, err := middleware.GetClaimsFromContext(r)
	if err != nil {
		log.Printf("❌ Get device history failed - Auth error: %v", err)
		http.Error(w, err.Error(), http.StatusUnauthorized)
		return
	}

	rows, err := h.DB.Query(`
		SELECT id, id_submit, nama_perangkat, category, merek, daya, durasi, quantity, Jenis_Pembayaran, Besar_Listrik, tanggal_input, Daily_Usage, Weekly_Usage, Monthly_Usage, Monthly_cost 
		FROM riwayat_perangkat 
		WHERE user_id = ? 
		ORDER BY tanggal_input ASC, id_submit DESC`,
		claims.UserID)
	if err != nil {
		log.Printf("❌ Get device history failed - Database error: %v", err)
		http.Error(w, "Failed to fetch device history", http.StatusInternalServerError)
		return
	}
	defer rows.Close()

	var devices []models.Device
	for rows.Next() {
		var device models.Device
		if err := rows.Scan(
			&device.ID, &device.ID_Submit, &device.Name, &device.Category, &device.Brand,
			&device.Power, &device.Duration, &device.Quantity, &device.Jenis_Pembayaran,
			&device.Besar_Listrik, &device.Tanggal_Input,
			&device.Daily_Usage, &device.Weekly_Usage, &device.Monthly_Usage, &device.Monthly_Cost,
		); err != nil {
			log.Printf("❌ Get device history failed - Scan error: %v", err)
			http.Error(w, "Failed to scan device data", http.StatusInternalServerError)
			return
		}
		devices = append(devices, device)
	}

	log.Printf("✅ Device history fetched successfully for user %d - Count: %d", claims.UserID, len(devices))
	json.NewEncoder(w).Encode(devices)
}

// formatRupiah memformat float64 ke format Rp. 123.456
func formatRupiah(amount float64) string {
	// Bulatkan ke bawah agar tidak ada desimal
	rounded := math.Floor(amount)

	// Konversi ke string
	amountStr := fmt.Sprintf("%.0f", rounded)

	// Tambahkan titik ribuan
	var result strings.Builder
	length := len(amountStr)

	for i, ch := range amountStr {
		if i > 0 && (length-i)%3 == 0 {
			result.WriteRune('.')
		}
		result.WriteRune(ch)
	}

	return "Rp. " + result.String()
}

// SaveAnalysisToDB menyimpan hasil analisis ke database
func (h *Handler) SaveAnalysisToDB(userID int, riwayatID int, totalPowerWh int, totalPowerKWh float64, aiResponse string, estimatedCost float64) error {
	// Format biaya bulanan ke Rupiah
	estimatedCostRp := formatRupiah(estimatedCost)

	query := `
        INSERT INTO hasil_analisis (
            user_id, 
            riwayat_id, 
            total_power_wh, 
            total_power_kwh, 
            ai_response, 
            estimated_cost_rp
        ) VALUES (?, ?, ?, ?, ?, ?)`

	_, err := h.DB.Exec(query,
		userID,
		riwayatID,
		totalPowerWh,
		totalPowerKWh,
		aiResponse,
		estimatedCostRp,
	)

	if err != nil {
		log.Printf("❌ Gagal menyimpan hasil analisis: %v", err)
		return fmt.Errorf("gagal menyimpan hasil analisis: %v", err)
	}

	log.Printf("✅ Hasil analisis berhasil disimpan untuk user %d dan riwayat_id %d", userID, riwayatID)
	return nil
}

// getTariffRate menerima besar_listrik (contoh: "900", "1300", "2200 VA") dan mengembalikan tarif per kWh
func getTariffRate(besarListrik string) float64 {
	// Extract VA value from besarListrik string
	var vaValue int
	fmt.Sscanf(besarListrik, "%d VA", &vaValue)

	// Determine tariff based on VA value
	switch {
	case vaValue == 450:
		return 415.0 // R-1/TR bersubsidi
	case vaValue == 900:
		// Check if it's subsidized or non-subsidized
		if strings.Contains(besarListrik, "bersubsidi") {
			return 605.0 // R-1/TR bersubsidi
		}
		return 1352.0 // R-1/TR Rumah Tangga Mampu / non-subsidi
	case vaValue == 1300 || vaValue == 2200:
		return 1444.70 // R-1/TR
	case vaValue >= 3500 && vaValue <= 5500:
		return 1699.53 // R-2/TR
	case vaValue >= 6600:
		return 1699.53 // R-3/TR
	default:
		return 1444.70 // Default to R-1/TR rate
	}
}

// calculateMonthlyCost menghitung biaya listrik per bulan berdasarkan penggunaan harian
func (h *Handler) calculateMonthlyCost(dailyUsageKWh float64, besarListrik string) float64 {
	tariffRate := getTariffRate(besarListrik)
	monthlyUsage := dailyUsageKWh * 30 // Asumsi 30 hari per bulan
	return monthlyUsage * tariffRate
}

// calculateUsageStats menghitung statistik penggunaan mingguan dan bulanan
func (h *Handler) calculateUsageStats(userID int) (models.UsageStats, error) {
	var stats models.UsageStats

	// Hitung penggunaan mingguan (7 hari terakhir)
	weeklyQuery := `
		SELECT COALESCE(SUM(daya * durasi / 1000), 0) as weekly_usage
		FROM riwayat_perangkat 
		WHERE user_id = ? 
		AND tanggal_input >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)`

	err := h.DB.QueryRow(weeklyQuery, userID).Scan(&stats.WeeklyUsage)
	if err != nil {
		return stats, fmt.Errorf("gagal menghitung penggunaan mingguan: %v", err)
	}

	// Hitung penggunaan bulanan (30 hari terakhir)
	monthlyQuery := `
		SELECT COALESCE(SUM(daya * durasi / 1000), 0) as monthly_usage
		FROM riwayat_perangkat 
		WHERE user_id = ? 
		AND tanggal_input >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)`

	err = h.DB.QueryRow(monthlyQuery, userID).Scan(&stats.MonthlyUsage)
	if err != nil {
		return stats, fmt.Errorf("gagal menghitung penggunaan bulanan: %v", err)
	}

	// Hitung rata-rata penggunaan harian
	stats.DailyAverage = stats.MonthlyUsage / 30

	return stats, nil
}

// GetRecentCalculations returns recent device calculations, usage statistics, and username
func (h *Handler) GetRecentCalculations(w http.ResponseWriter, r *http.Request) {
	log.Printf("📊 Starting GetRecentCalculations request")

	claims, err := middleware.GetClaimsFromContext(r)
	if err != nil {
		log.Printf("❌ Get recent calculations failed - Auth error: %v", err)
		http.Error(w, err.Error(), http.StatusUnauthorized)
		return
	}
	log.Printf("✅ Authentication successful for user ID: %d", claims.UserID)

	// Get username
	var username string
	err = h.DB.QueryRow("SELECT username FROM users WHERE user_id = ?", claims.UserID).Scan(&username)
	if err != nil {
		log.Printf("❌ Get recent calculations failed - Failed to get username: %v", err)
		http.Error(w, "Failed to get user data", http.StatusInternalServerError)
		return
	}
	log.Printf("✅ Retrieved username: %s", username)

	// Get recent calculations (last 5 entries)
	log.Printf("📥 Fetching recent calculations for user ID: %d", claims.UserID)
	rows, err := h.DB.Query(`
		SELECT 
			merek as brand,
			nama_perangkat as name,
			category,
			daya as power,
			durasi as usage_hours,
			Daily_Usage as total_kwh,
			DATE_FORMAT(tanggal_input, '%Y-%m-%d') as date
		FROM riwayat_perangkat 
		WHERE user_id = ? 
		ORDER BY tanggal_input ASC, id DESC
		LIMIT 5`,
		claims.UserID)
	if err != nil {
		log.Printf("❌ Get recent calculations failed - Database error: %v", err)
		http.Error(w, "Failed to fetch recent calculations", http.StatusInternalServerError)
		return
	}
	defer rows.Close()

	var recentCalculations []map[string]interface{}
	for rows.Next() {
		var calc struct {
			Brand      string  `json:"brand"`
			Name       string  `json:"name"`
			Category   string  `json:"category"`
			Power      int     `json:"power"`
			UsageHours int     `json:"usage_hours"`
			TotalKWh   float64 `json:"total_kwh"`
			Date       string  `json:"date"`
		}
		if err := rows.Scan(&calc.Brand, &calc.Name, &calc.Category, &calc.Power, &calc.UsageHours, &calc.TotalKWh, &calc.Date); err != nil {
			log.Printf("❌ Get recent calculations failed - Scan error for device %s: %v", calc.Name, err)
			continue
		}
		recentCalculations = append(recentCalculations, map[string]interface{}{
			"brand":       calc.Brand,
			"name":        calc.Name,
			"category":    calc.Category,
			"power":       calc.Power,
			"usage_hours": calc.UsageHours,
			"total_kwh":   calc.TotalKWh,
			"date":        calc.Date,
		})
		log.Printf("✅ Processed device: %s (%s) - Power: %dW, Usage: %d hours, Total kWh: %.2f",
			calc.Name, calc.Brand, calc.Power, calc.UsageHours, calc.TotalKWh)
	}
	log.Printf("📊 Retrieved %d recent calculations", len(recentCalculations))

	// Get today's usage
	log.Printf("📥 Fetching today's usage for user ID: %d", claims.UserID)
	var todayUsage float64
	err = h.DB.QueryRow(`
		SELECT COALESCE(SUM(Daily_Usage), 0)
		FROM riwayat_perangkat 
		WHERE user_id = ? 
		AND DATE(tanggal_input) = CURDATE()`,
		claims.UserID).Scan(&todayUsage)
	if err != nil {
		log.Printf("❌ Get recent calculations failed - Failed to get today's usage: %v", err)
		todayUsage = 0
	}
	log.Printf("✅ Today's usage: %.2f kWh", todayUsage)

	// Get weekly usage
	log.Printf("📥 Fetching weekly usage for user ID: %d", claims.UserID)
	var weeklyUsage float64
	err = h.DB.QueryRow(`
		SELECT COALESCE(SUM(Daily_Usage), 0)
		FROM riwayat_perangkat 
		WHERE user_id = ? 
		AND tanggal_input >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)`,
		claims.UserID).Scan(&weeklyUsage)
	if err != nil {
		log.Printf("❌ Get recent calculations failed - Failed to get weekly usage: %v", err)
		weeklyUsage = 0
	}
	log.Printf("✅ Weekly usage: %.2f kWh", weeklyUsage)

	// Get monthly cost
	log.Printf("📥 Fetching monthly cost for user ID: %d", claims.UserID)
	var monthlyCost float64
	err = h.DB.QueryRow(`
		SELECT COALESCE(SUM(Monthly_cost), 0)
		FROM riwayat_perangkat 
		WHERE user_id = ? 
		AND tanggal_input >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)`,
		claims.UserID).Scan(&monthlyCost)
	if err != nil {
		log.Printf("❌ Get recent calculations failed - Failed to get monthly cost: %v", err)
		monthlyCost = 0
	}
	log.Printf("✅ Monthly cost: %s", formatRupiah(monthlyCost))

	// Prepare response
	response := map[string]interface{}{
		"username":            username,
		"recent_calculations": recentCalculations,
		"today_usage":         todayUsage,
		"weekly_usage":        weeklyUsage,
		"monthly_cost":        formatRupiah(monthlyCost),
	}

	log.Printf("📤 Sending response for user %s with %d recent calculations", username, len(recentCalculations))
	w.Header().Set("Content-Type", "application/json")
	if err := json.NewEncoder(w).Encode(response); err != nil {
		log.Printf("❌ Get recent calculations failed - Response encoding error: %v", err)
		http.Error(w, "Failed to encode response", http.StatusInternalServerError)
		return
	}
	log.Printf("✅ GetRecentCalculations completed successfully for user %s", username)
}

// GetCategoryCounts returns the count of devices for each category for the authenticated user
func (h *Handler) GetCategoryCounts(w http.ResponseWriter, r *http.Request) {
	claims, err := middleware.GetClaimsFromContext(r)
	if err != nil {
		log.Printf("❌ Get category counts failed - Auth error: %v", err)
		http.Error(w, err.Error(), http.StatusUnauthorized)
		return
	}

	rows, err := h.DB.Query(`
		SELECT category, COUNT(*) as count
		FROM riwayat_perangkat
		WHERE user_id = ?
		GROUP BY category
	`, claims.UserID)
	if err != nil {
		log.Printf("❌ Get category counts failed - Database error: %v", err)
		http.Error(w, "Failed to fetch category counts", http.StatusInternalServerError)
		return
	}
	defer rows.Close()

	var counts []models.DeviceCategoryCount
	for rows.Next() {
		var c models.DeviceCategoryCount
		if err := rows.Scan(&c.Category, &c.Count); err != nil {
			log.Printf("❌ Get category counts failed - Scan error: %v", err)
			http.Error(w, "Failed to scan category count data", http.StatusInternalServerError)
			return
		}
		counts = append(counts, c)
	}

	log.Printf("✅ Category counts fetched successfully for user %d - Count: %d", claims.UserID, len(counts))
	//data each category dan count
	for _, count := range counts {
		log.Printf("✅ Category: %s, Count: %d", count.Category, count.Count)
	}
	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(counts)
}

func (h *Handler) GetWeeklyCostStatistics(w http.ResponseWriter, r *http.Request) {
	claims, err := middleware.GetClaimsFromContext(r)
	if err != nil {
		http.Error(w, err.Error(), http.StatusUnauthorized)
		return
	}

	now := time.Now()
	weekday := int(now.Weekday())
	if weekday == 0 {
		weekday = 7
	}
	thisMonday := now.AddDate(0, 0, -(weekday - 1))

	type WeeklyCost struct {
		WeekLabel string  `json:"week"`
		Cost      float64 `json:"cost"`
	}
	var stats []WeeklyCost

	for i := 3; i >= 0; i-- {
		weekStart := thisMonday.AddDate(0, 0, -7*i)
		weekEnd := weekStart.AddDate(0, 0, 6)
		rows, err := h.DB.Query(`
			SELECT Daily_Usage, Besar_Listrik
			FROM riwayat_perangkat
			WHERE user_id = ? AND tanggal_input >= ? AND tanggal_input <= ?`,
			claims.UserID, weekStart.Format("2006-01-02"), weekEnd.Format("2006-01-02"),
		)
		if err != nil {
			log.Printf("❌ Weekly cost query failed for week %s - %s: %v", weekStart.Format("2006-01-02"), weekEnd.Format("2006-01-02"), err)
			http.Error(w, "Failed to fetch weekly cost", http.StatusInternalServerError)
			return
		}
		defer rows.Close()

		var cost float64
		for rows.Next() {
			var dailyUsage float64
			var besarListrik string
			if err := rows.Scan(&dailyUsage, &besarListrik); err != nil {
				log.Printf("❌ Scan error: %v", err)
				continue
			}
			cost += dailyUsage * getTariffRate(besarListrik)
		}

		label := fmt.Sprintf("%s - %s", weekStart.Format("02/01"), weekEnd.Format("02/01"))
		log.Printf("✅ Weekly cost: %s - %s: %s", weekStart.Format("02/01"), weekEnd.Format("02/01"), formatRupiah(cost))
		stats = append(stats, WeeklyCost{WeekLabel: label, Cost: cost})
	}

	log.Printf("[WEEKLY COST] Final stats: %+v", stats)
	json.NewEncoder(w).Encode(stats)
}
