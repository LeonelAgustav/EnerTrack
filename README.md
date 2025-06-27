# EnerTrack Project

EnerTrack adalah aplikasi monitoring dan analisis konsumsi energi listrik rumah tangga, terdiri dari dua bagian utama:

- **EnerTrack-BE**: Backend API berbasis Go
- **EnerTrack-WEB**: Frontend web berbasis Laravel (PHP)

---

## Struktur Folder

```
EnerTrack_Test/
├── EnerTrack-BE/           # Backend Go (REST API)
├── EnerTrack-WEB/    # Frontend Laravel (PHP)
└── README.md         # Dokumentasi utama
```

---

## 1. Backend: EnerTrack-BE (Go)

### Fitur Utama
- REST API untuk autentikasi, device, statistik, analisis AI
- Koneksi ke database MySQL
- JWT Auth
- Perhitungan statistik energi dan biaya

### Cara Menjalankan
1. Masuk ke folder backend:
   ```sh
   cd EnerTrack-BE
   ```
2. Copy `.env.example` ke `.env` dan sesuaikan konfigurasi DB & API key jika ada.
2. Install dependency (jika pakai Go modules):
   ```sh
   go mod tidy
   ```
3. Jalankan server:
   ```sh
   go run main.go
   ```
4. Server berjalan di `http://localhost:8082` (atau port sesuai konfigurasi).

---

## 2. Frontend: EnerTrack-WEB (Laravel)

### Fitur Utama
- UI dashboard, kalkulator, analisis energi
- Autentikasi user
- Konsumsi data dari API backend
- Visualisasi data (Chart.js)

### Cara Menjalankan
1. Masuk ke folder frontend:
   ```sh
   cd EnerTrack-WEB
   ```
2. Copy `.env.example` ke `.env` dan sesuaikan konfigurasi DB & API URL backend.
3. Install dependency:
   ```sh
   composer install
   npm install
   ```
4. Generate key Laravel:
   ```sh
   php artisan key:generate
   ```
5. Jalankan migration (jika perlu):
   ```sh
   php artisan migrate
   ```
6. Jalankan server Laravel:
   ```sh
   php artisan serve
   ```
7. (Opsional) Jalankan frontend asset watcher:
   ```sh
   npm run dev
   ```
8. Akses di `http://localhost:8000`

---

## 3. Koneksi Backend & Frontend
- Pastikan variabel `API_BASE_URL` di `.env` Laravel mengarah ke backend Go (misal: `http://localhost:8082`)
- Pastikan backend dan frontend berjalan bersamaan

---

## 4. Catatan
- Tambahkan `.gitignore` untuk file/folder yang tidak perlu di-push (misal: `vendor/`, `node_modules/`, `storage/`, `*.log`, dsb)
- Untuk pengembangan AI, pastikan API key sudah diatur di environment backend

---

## 5. Kontribusi
Pull request dan issue sangat diterima!

---

## 6. Lisensi
MIT
