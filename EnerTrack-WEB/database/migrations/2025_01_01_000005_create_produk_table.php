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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merek_id')->nullable()->constrained('merek')->onDelete('cascade');
            $table->foreignId('kategori_id')->nullable()->constrained('kategori')->onDelete('cascade');
            $table->string('nama_produk', 100);
            $table->string('model', 50)->nullable();
            $table->integer('daya_watt')->nullable();
            $table->string('kapasitas', 50)->nullable();
            $table->decimal('harga', 15, 2)->nullable();
            $table->integer('stok')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
}; 