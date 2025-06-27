<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_perangkat', function (Blueprint $table) {
            $table->id();
            $table->string('id_submit', 36);
            $table->unsignedBigInteger('user_id');
            $table->string('Jenis_Pembayaran', 255);
            $table->string('Besar_Listrik', 50);
            $table->string('nama_perangkat', 255);
            $table->string('category', 255);
            $table->string('merek', 255);
            $table->float('daya');
            $table->float('durasi');
            $table->integer('quantity')->nullable();
            $table->decimal('daily_usage', 10, 2)->nullable();
            $table->float('Weekly_Usage')->nullable();
            $table->float('Monthly_Usage')->nullable();
            $table->float('Monthly_cost')->nullable();
            $table->date('tanggal_input');
            
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_perangkat');
    }
}; 