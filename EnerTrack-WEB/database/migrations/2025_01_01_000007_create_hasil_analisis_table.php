<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasil_analisis', function (Blueprint $table) {
            $table->id('id_analisis');
            $table->unsignedBigInteger('user_id');
            $table->foreignId('riwayat_id')->constrained('riwayat_perangkat');
            $table->integer('total_power_wh');
            $table->text('ai_response');
            $table->datetime('tanggal_analisis')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->float('total_power_kwh')->nullable();
            $table->string('estimated_cost_rp', 50)->nullable();
            
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_analisis');
    }
}; 