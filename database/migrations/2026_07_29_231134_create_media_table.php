<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['image', 'social'])->default('image'); // 'image' = upload gambar, 'social' = link IG/TikTok
            $table->string('image')->nullable();      // path gambar (untuk tipe 'image')
            $table->string('url')->nullable();        // URL "Baca Selengkapnya" (tipe image) atau link reel (tipe social)
            $table->enum('platform', ['instagram', 'tiktok', 'youtube', 'other'])->nullable(); // untuk tipe 'social'
            $table->boolean('is_featured')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
