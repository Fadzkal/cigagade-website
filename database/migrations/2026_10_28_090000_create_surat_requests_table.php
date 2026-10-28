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
        Schema::create('surat_requests', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code', 30)->unique();
            $table->string('jenis_surat', 20); // sku, skbb, skd, sktm, skm, skbm, skp
            $table->string('nomor_surat', 100)->nullable();
            $table->enum('status', ['pending', 'diproses', 'selesai', 'ditolak'])->default('pending');
            $table->text('catatan')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->string('nama_kades', 100)->default('DEVI FAHRUROJI, S.Pd.I.');
            $table->string('jabatan_kades', 100)->default('Kepala Desa Cigagade');

            // Data Pemohon
            $table->string('nama_lengkap', 150);
            $table->string('nik', 20);
            $table->string('no_kk', 20)->nullable();
            $table->string('no_telepon', 30);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin', 20)->default('Laki-laki');
            $table->string('warga_negara', 50)->default('Indonesia');
            $table->string('agama', 30)->default('Islam');
            $table->string('status_perkawinan', 50)->default('Belum Kawin');
            $table->string('pekerjaan', 100)->default('Buruh Harian Lepas');
            $table->string('alamat', 255)->default('KP. Cigagade');
            $table->string('rt', 10)->default('001');
            $table->string('rw', 10)->default('001');
            $table->string('desa', 100)->default('Cigagade');
            $table->string('kecamatan', 100)->default('Balubur Limbangan');
            $table->string('kabupaten', 100)->default('Garut');
            $table->text('keperluan')->nullable();

            // Data Spesifik sesuai jenis surat (SKU, SKM, SKBM, SKP, dll)
            $table->json('data_spesifik')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_requests');
    }
};
