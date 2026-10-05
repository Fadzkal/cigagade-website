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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // Menghubungkan ke tabel 'users' (siapa penulisnya)
            // onDelete('cascade') artinya jika user dihapus, postingannya juga terhapus
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Menghubungkan ke tabel 'categories' (kategorinya apa)
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            $table->string('title'); // Judul Berita
            $table->string('slug')->unique(); // Untuk URL berita
            $table->text('excerpt'); // Ringkasan singkat berita
            $table->longText('content'); // Isi lengkap berita
            $table->string('image')->nullable(); // Path/URL gambar thumbnail

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
