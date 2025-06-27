<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merek extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'merek';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_merek',
        'negara_asal',
        'tahun_berdiri',
        'website',
    ];

    /**
     * Get the produk for the merek.
     */
    public function produk()
    {
        return $this->hasMany(Produk::class, 'merek_id');
    }
} 