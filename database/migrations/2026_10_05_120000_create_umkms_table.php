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
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Produk
            $table->string('slug')->unique(); // Slug URL
            $table->string('seller_name'); // Nama Pemilik / Penjual UMKM
            $table->string('phone'); // No WhatsApp Penjual
            $table->string('category')->default('Makanan & Minuman'); // Kategori produk
            $table->decimal('price', 12, 0); // Harga produk (Rupiah)
            $table->string('unit')->nullable()->default('/ bungkus'); // Satuan harga (/ pcs, / kg, dll)
            $table->text('description'); // Deskripsi produk
            $table->string('address')->nullable(); // Alamat / Dusun di Cigagade
            $table->string('image')->nullable(); // Foto produk
            $table->boolean('is_active')->default(true); // Status ketersediaan
            $table->unsignedBigInteger('views')->default(0); // Jumlah dilihat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
