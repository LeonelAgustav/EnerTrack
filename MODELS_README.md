# Models Documentation

## Overview
This document describes all the Eloquent models created for the EnerTrack application and their relationships.

## Models

### 1. User Model
**File:** `app/Models/User.php`
**Table:** `users`

#### Attributes:
- `user_id` (Primary Key)
- `fullname`
- `username` (Unique)
- `email` (Unique)
- `email_verified_at`
- `password`
- `remember_token`
- `created_at`
- `updated_at`

#### Relationships:
- `hasMany` RiwayatPerangkat
- `hasMany` HasilAnalisis

#### Usage:
```php
// Create user
$user = User::create([
    'fullname' => 'John Doe',
    'username' => 'johndoe',
    'email' => 'john@example.com',
    'password' => Hash::make('password')
]);

// Get user's device history
$riwayat = $user->riwayatPerangkat;

// Get user's analysis results
$analisis = $user->hasilAnalisis;
```

### 2. Kategori Model
**File:** `app/Models/Kategori.php`
**Table:** `kategori`

#### Attributes:
- `id` (Primary Key)
- `nama_kategori` (Unique)

#### Relationships:
- `hasMany` Produk

#### Usage:
```php
// Get all categories
$kategoris = Kategori::all();

// Get products in a category
$kategori = Kategori::find(1);
$produks = $kategori->produk;
```

### 3. Merek Model
**File:** `app/Models/Merek.php`
**Table:** `merek`

#### Attributes:
- `id` (Primary Key)
- `nama_merek` (Unique)
- `negara_asal`
- `tahun_berdiri`
- `website`

#### Relationships:
- `hasMany` Produk

#### Usage:
```php
// Get all brands
$mereks = Merek::all();

// Get products by brand
$merek = Merek::find(1);
$produks = $merek->produk;
```

### 4. Produk Model
**File:** `app/Models/Produk.php`
**Table:** `produk`

#### Attributes:
- `id` (Primary Key)
- `merek_id` (Foreign Key)
- `kategori_id` (Foreign Key)
- `nama_produk`
- `model`
- `daya_watt`
- `kapasitas`
- `harga`
- `stok`

#### Casts:
- `harga` → decimal:2
- `daya_watt` → integer
- `stok` → integer

#### Relationships:
- `belongsTo` Merek
- `belongsTo` Kategori

#### Usage:
```php
// Create product
$produk = Produk::create([
    'merek_id' => 1,
    'kategori_id' => 1,
    'nama_produk' => 'Laptop Gaming',
    'daya_watt' => 135,
    'harga' => 15000000,
    'stok' => 10
]);

// Get product with relationships
$produk = Produk::with(['merek', 'kategori'])->find(1);
```

### 5. RiwayatPerangkat Model
**File:** `app/Models/RiwayatPerangkat.php`
**Table:** `riwayat_perangkat`

#### Attributes:
- `id` (Primary Key)
- `id_submit`
- `user_id` (Foreign Key)
- `Jenis_Pembayaran`
- `Besar_Listrik`
- `nama_perangkat`
- `category`
- `merek`
- `daya`
- `durasi`
- `quantity`
- `daily_usage`
- `Weekly_Usage`
- `Monthly_Usage`
- `Monthly_cost`
- `tanggal_input`

#### Casts:
- `daya` → float
- `durasi` → float
- `quantity` → integer
- `daily_usage` → decimal:2
- `Weekly_Usage` → float
- `Monthly_Usage` → float
- `Monthly_cost` → float
- `tanggal_input` → date

#### Relationships:
- `belongsTo` User
- `hasMany` HasilAnalisis

#### Usage:
```php
// Create device history
$riwayat = RiwayatPerangkat::create([
    'user_id' => 1,
    'nama_perangkat' => 'Laptop',
    'daya' => 135,
    'durasi' => 8,
    'category' => 'Entertainment'
]);

// Get user's device history
$user = User::find(1);
$riwayat = $user->riwayatPerangkat;
```

### 6. HasilAnalisis Model
**File:** `app/Models/HasilAnalisis.php`
**Table:** `hasil_analisis`

#### Attributes:
- `id_analisis` (Primary Key)
- `user_id` (Foreign Key)
- `riwayat_id` (Foreign Key)
- `total_power_wh`
- `ai_response`
- `tanggal_analisis`
- `total_power_kwh`
- `estimated_cost_rp`

#### Casts:
- `total_power_wh` → integer
- `total_power_kwh` → float
- `tanggal_analisis` → datetime

#### Relationships:
- `belongsTo` User
- `belongsTo` RiwayatPerangkat

#### Usage:
```php
// Create analysis result
$analisis = HasilAnalisis::create([
    'user_id' => 1,
    'riwayat_id' => 1,
    'total_power_wh' => 1080,
    'ai_response' => 'Analysis result...',
    'total_power_kwh' => 1.08
]);

// Get analysis with relationships
$analisis = HasilAnalisis::with(['user', 'riwayatPerangkat'])->find(1);
```

## Relationships Overview

```
User (user_id)
├── hasMany RiwayatPerangkat (user_id)
└── hasMany HasilAnalisis (user_id)

Kategori (id)
└── hasMany Produk (kategori_id)

Merek (id)
└── hasMany Produk (merek_id)

Produk (id)
├── belongsTo Merek (merek_id)
└── belongsTo Kategori (kategori_id)

RiwayatPerangkat (id)
├── belongsTo User (user_id)
└── hasMany HasilAnalisis (riwayat_id)

HasilAnalisis (id_analisis)
├── belongsTo User (user_id)
└── belongsTo RiwayatPerangkat (riwayat_id)
```

## Common Queries

### Get User with All Related Data
```php
$user = User::with([
    'riwayatPerangkat.hasilAnalisis',
    'hasilAnalisis.riwayatPerangkat'
])->find(1);
```

### Get Products with Brand and Category
```php
$produks = Produk::with(['merek', 'kategori'])->get();
```

### Get Analysis Results with User and Device History
```php
$analisis = HasilAnalisis::with(['user', 'riwayatPerangkat'])->get();
```

### Filter Products by Category
```php
$produks = Produk::where('kategori_id', 1)->with('merek')->get();
```

### Get User's Monthly Usage Summary
```php
$monthlyUsage = RiwayatPerangkat::where('user_id', 1)
    ->selectRaw('SUM(Monthly_Usage) as total_usage, SUM(Monthly_cost) as total_cost')
    ->first();
```

## Model Events and Observers

You can add model events and observers for:
- Automatic calculation of usage and costs
- Validation of power consumption
- Logging of analysis results
- User activity tracking

## Validation Rules

Consider adding validation rules for:
- Power consumption limits
- Valid device categories
- Date ranges for analysis
- Cost calculations accuracy 