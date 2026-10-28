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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tiket')->unique()->index();
            $table->string('nama')->nullable(); // Opsional
            $table->boolean('is_anonim')->default(false); // Flag jika pelapor ingin identitasnya dirahasiakan
            $table->string('kontak')->nullable(); // No WhatsApp / Telp / Email (opsional)
            $table->string('kategori')->default('Lainnya'); // Infrastruktur & Jalan, Kebersihan, Pelayanan, dll
            $table->string('judul');
            $table->text('isi_pengaduan');
            $table->string('lokasi')->nullable(); // Lokasi spesifik, RT/RW, Dusun
            $table->string('foto_bukti')->nullable(); // Path gambar bukti (opsional)
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu')->index();
            $table->text('tanggapan')->nullable(); // Jawaban tindak lanjut Superadmin
            $table->timestamp('tanggapan_at')->nullable();
            $table->string('tanggapan_oleh')->nullable();
            $table->boolean('is_public')->default(true); // Tampil di transparansi publik
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
