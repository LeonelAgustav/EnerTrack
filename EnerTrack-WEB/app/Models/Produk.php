<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'produk';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'merek_id',
        'kategori_id',
        'nama_produk',
        'model',
        'daya_watt',
        'kapasitas',
        'harga',
        'stok',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'harga' => 'decimal:2',
        'daya_watt' => 'integer',
        'stok' => 'integer',
    ];

    /**
     * Get the merek that owns the produk.
     */
    public function merek()
    {
        return $this->belongsTo(Merek::class, 'merek_id');
    }

    /**
     * Get the kategori that owns the produk.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
} 