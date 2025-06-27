<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilAnalisis extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hasil_analisis';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_analisis';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'riwayat_id',
        'total_power_wh',
        'ai_response',
        'tanggal_analisis',
        'total_power_kwh',
        'estimated_cost_rp',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_power_wh' => 'integer',
        'total_power_kwh' => 'float',
        'tanggal_analisis' => 'datetime',
    ];

    /**
     * Get the user that owns the hasil analisis.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the riwayat perangkat that owns the hasil analisis.
     */
    public function riwayatPerangkat()
    {
        return $this->belongsTo(RiwayatPerangkat::class, 'riwayat_id');
    }
} 