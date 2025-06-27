# Migration Documentation

## Overview
This document describes the database migrations created for the EnerTrack application based on the SQL structure.

## Migration Files

### 1. Existing Migrations (Updated)
- `0001_01_01_000000_create_users_table.php` - Users table with user_id, fullname, username
- `0001_01_01_000001_create_cache_table.php` - Cache tables
- `0001_01_01_000002_create_jobs_table.php` - Job queue tables

### 2. New Migrations (Custom)
- `2025_01_01_000003_create_kategori_table.php` - Product categories
- `2025_01_01_000004_create_merek_table.php` - Product brands
- `2025_01_01_000005_create_produk_table.php` - Products table
- `2025_01_01_000006_create_riwayat_perangkat_table.php` - Device history
- `2025_01_01_000007_create_hasil_analisis_table.php` - Analysis results

## Database Structure

### Tables Created:
1. **users** - User accounts with user_id, fullname, username, email, password
2. **kategori** - Product categories (8 categories)
3. **merek** - Product brands (200 brands)
4. **produk** - Products with foreign keys to kategori and merek
5. **riwayat_perangkat** - Device usage history with foreign key to users
6. **hasil_analisis** - Analysis results with foreign keys to users and riwayat_perangkat

### Relationships:
- `users` ← `riwayat_perangkat` (user_id)
- `users` ← `hasil_analisis` (user_id)
- `riwayat_perangkat` ← `hasil_analisis` (riwayat_id)
- `kategori` ← `produk` (kategori_id)
- `merek` ← `produk` (merek_id)

## How to Run

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Run Seeders (Optional)
```bash
php artisan db:seed
```

### 3. Run Specific Seeder
```bash
php artisan db:seed --class=KategoriSeeder
php artisan db:seed --class=MerekSeeder
```

## Rollback

### Rollback All Migrations
```bash
php artisan migrate:rollback
```

### Rollback Specific Migration
```bash
php artisan migrate:rollback --step=1
```

## Notes

### Important Changes:
1. **Users Table**: Primary key is `user_id` (not `id`)
2. **New Columns**: `fullname` and `username` in users table
3. **Foreign Keys**: All foreign keys properly reference `user_id` in users table
4. **Data Types**: Matches the original SQL structure exactly

### Seeder Data:
- **KategoriSeeder**: 8 product categories
- **MerekSeeder**: 200 product brands with complete information

### Constraints:
- Unique constraints on `nama_kategori`, `nama_merek`, `username`, and `email`
- Foreign key constraints with cascade delete where appropriate
- Proper indexing on foreign key columns

## Troubleshooting

### Common Issues:
1. **Foreign Key Errors**: Ensure migrations run in correct order
2. **Duplicate Data**: Use `php artisan migrate:fresh` to start clean
3. **Seeder Errors**: Check if tables exist before running seeders

### Reset Database:
```bash
php artisan migrate:fresh --seed
```

This will drop all tables, run all migrations, and seed the database with initial data. 