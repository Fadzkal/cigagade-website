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
        Schema::create('infografis', function (Blueprint $table) {
            $table->id();
            $table->string('category')->index(); // penduduk, apbdes, stunting, bansos, idm, sdgs
            $table->string('section')->default('summary'); // summary, piramida, pendidikan, pekerjaan, agama, dusun, rincian, tujuan, dll.
            $table->string('key')->index(); // unique key for retrieval/update
            $table->string('title'); // Label / Judul Indikator
            $table->text('value'); // Nilai utama (angka / teks)
            $table->text('value_alt')->nullable(); // Nilai sekunder (contoh: jumlah perempuan pd piramida)
            $table->string('unit')->nullable(); // Satuan: Jiwa, KK, Rp, %, Balita, dll.
            $table->string('icon')->nullable(); // FontAwesome class: fas fa-users, dll.
            $table->string('color')->nullable()->default('emerald'); // emerald, blue, amber, rose, indigo, purple
            $table->integer('order_index')->default(0); // Urutan tampil
            $table->json('meta')->nullable(); // Metadata opsional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infografis');
    }
};
