package db

import (
	"database/sql"
	"log"

	_ "github.com/go-sql-driver/mysql"
)

var DB *sql.DB

func InitDB() {
	var err error
	// Update this with your MySQL root password
	DB, err = sql.Open("mysql", "root:@tcp(127.0.0.1:3306)/elektronik_rumah")
	if err != nil {
		log.Fatal("Failed to connect to database:", err)
	}

	if err := DB.Ping(); err != nil {
		log.Fatalf("Database tidak bisa dijangkau: %v", err)
	}

	log.Println("✅ Database berhasil terkoneksi")
}
