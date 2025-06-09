package main

import (
	"context"
	"fmt"
	"log"
	"net/http"
	"os"

	"EnerTrack-BE/db"
	"EnerTrack-BE/handlers"
	"EnerTrack-BE/middleware"

	"github.com/google/generative-ai-go/genai"
	"google.golang.org/api/option"
)

func main() {
	// Check for API key at startup
	apiKey := os.Getenv("GEMINI_API_KEY")
	if apiKey == "" {
		log.Fatalln("⚠️ GEMINI_API_KEY tidak ditemukan dalam variabel lingkungan")
	} else {
		log.Println("✅ GEMINI_API_KEY ditemukan")
	}

	// Setup AI client
	ctx := context.Background()
	client, err := genai.NewClient(ctx, option.WithAPIKey(apiKey))
	if err != nil {
		log.Fatalf("Error creating AI client: %v", err)
	} else {
		log.Println("✅ AI client berhasil dibuat")
	}
	defer client.Close()

	model := client.GenerativeModel("gemini-2.0-flash")
	model.SetTemperature(1)
	model.SetTopK(40)
	model.SetTopP(0.95)
	model.SetMaxOutputTokens(8192)
	model.ResponseMIMEType = "text/plain"

	// Initialize database connection
	db.InitDB()
	defer db.DB.Close()

	handler := handlers.NewHandler(db.DB)
	handler.Client = client
	handler.Model = model

	// Public routes
	http.HandleFunc("/api/register", middleware.CORSMiddleware(middleware.LoggingMiddleware(handler.Register)))
	http.HandleFunc("/api/auth/login", middleware.CORSMiddleware(middleware.LoggingMiddleware(handler.Login)))
	http.HandleFunc("/api/brands", middleware.CORSMiddleware(middleware.LoggingMiddleware(handler.GetBrands)))

	// Protected routes
	http.HandleFunc("/api/devices/submit", middleware.CORSMiddleware(middleware.LoggingMiddleware(middleware.AuthMiddleware(handler.SubmitDevice))))
	http.HandleFunc("/api/analyze", middleware.CORSMiddleware(middleware.LoggingMiddleware(middleware.AuthMiddleware(handler.Analyze))))
	http.HandleFunc("/api/statistics/daily", middleware.CORSMiddleware(middleware.LoggingMiddleware(middleware.AuthMiddleware(handler.GetDailyStatistics))))
	http.HandleFunc("/api/devices/history", middleware.CORSMiddleware(middleware.LoggingMiddleware(middleware.AuthMiddleware(handler.GetDeviceHistory))))
	http.HandleFunc("/api/recent-calculations", middleware.CORSMiddleware(middleware.LoggingMiddleware(middleware.AuthMiddleware(handler.GetRecentCalculations))))
	http.HandleFunc("/api/category-counts", middleware.CORSMiddleware(middleware.LoggingMiddleware(middleware.AuthMiddleware(handler.GetCategoryCounts))))
	http.HandleFunc("/api/weekly-cost-statistics", middleware.CORSMiddleware(middleware.LoggingMiddleware(middleware.AuthMiddleware(handler.GetWeeklyCostStatistics))))

	fmt.Println("Server running on http://localhost:8082")
	log.Fatal(http.ListenAndServe(":8082", nil))
}
