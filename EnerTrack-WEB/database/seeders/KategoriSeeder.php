<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Perangkat Komputer & Laptop'],
            ['nama_kategori' => 'Smartphone & Tablet'],
            ['nama_kategori' => 'TV & Home Entertainment'],
            ['nama_kategori' => 'Audio & Headphone'],
            ['nama_kategori' => 'Kamera & Aksesori Fotografi'],
            ['nama_kategori' => 'Konsol Game'],
            ['nama_kategori' => 'Peralatan Rumah Tangga Elektronik'],
            ['nama_kategori' => 'Perangkat Jaringan & Router'],
        ];

        foreach ($kategoris as $kategori) {
            DB::table('kategori')->insert($kategori);
        }
    }
} 