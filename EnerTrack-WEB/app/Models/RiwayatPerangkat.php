<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPerangkat extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'riwayat_perangkat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_submit',
        'user_id',
        'Jenis_Pembayaran',
        'Besar_Listrik',
        'nama_perangkat',
        'category',
        'merek',
        'daya',
        'durasi',
        'quantity',
        'daily_usage',
        'Weekly_Usage',
        'Monthly_Usage',
        'Monthly_cost',
        'tanggal_input',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'daya' => 'float',
        'durasi' => 'float',
        'quantity' => 'integer',
        'daily_usage' => 'decimal:2',
        'Weekly_Usage' => 'float',
        'Monthly_Usage' => 'float',
        'Monthly_cost' => 'float',
        'tanggal_input' => 'date',
    ];

    /**
     * Get the user that owns the riwayat perangkat.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the hasil analisis for the riwayat perangkat.
     */
    public function hasilAnalisis()
    {
        return $this->hasMany(HasilAnalisis::class, 'riwayat_id');
    }
} 