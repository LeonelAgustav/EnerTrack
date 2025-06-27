package models

import (
	"github.com/golang-jwt/jwt/v5"
)

type Claims struct {
	UserID int    `json:"user_id"`
	Email  string `json:"email"`
	jwt.RegisteredClaims
}

type User struct {
	ID       int    `json:"id"`
	Email    string `json:"email"`
	Password string `json:"password"`
}

type Device struct {
	ID               int     `json:"id"`
	UserID           int     `json:"user_id"`
	Name             string  `json:"name"`
	Category         string  `json:"category"`
	Brand            string  `json:"brand"`
	Power            int     `json:"power"`
	Duration         int     `json:"duration"`
	Quantity         int     `json:"quantity"`
	Jenis_Pembayaran string  `json:"jenisPembayaran"`
	Besar_Listrik    string  `json:"besarListrik"`
	Tanggal_Input    string  `json:"tanggalInput"`
	ID_Submit        string  `json:"idSubmit"`
	Daily_Usage      float64 `json:"daily_usage,omitempty"`
	Weekly_Usage     float64 `json:"weekly_usage,omitempty"`
	Monthly_Usage    float64 `json:"monthly_usage,omitempty"`
	Monthly_Cost     float64 `json:"monthly_cost,omitempty"`
}

type Brand struct {
	ID   int    `json:"id"`
	Name string `json:"name"`
}

type DailyStat struct {
	Date        string  `json:"date"`
	Consumption float64 `json:"consumption"`
}

// UsageStats menyimpan statistik penggunaan listrik
type UsageStats struct {
	WeeklyUsage  float64 `json:"weekly_usage"`  // Penggunaan dalam 7 hari terakhir (kWh)
	MonthlyUsage float64 `json:"monthly_usage"` // Penggunaan dalam 30 hari terakhir (kWh)
	DailyAverage float64 `json:"daily_average"` // Rata-rata penggunaan harian (kWh)
}

// DeviceCategoryCount is used to return the count of devices per category
// for statistics or analytics endpoints.
type DeviceCategoryCount struct {
	Category string `json:"category"`
	Count    int    `json:"count"`
}

// User profile response structure
type UserProfile struct {
	ID       uint   `json:"id"`
	FullName string `json:"full_name"`
	Username string `json:"username"`
	Email    string `json:"email"`
}
