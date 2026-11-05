<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Pengaduan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->boolean('is_public')->default(false)->change();
        });

        // Set is_public = false for all unconfirmed / rejected complaints
        Pengaduan::whereIn('status', ['menunggu', 'ditolak'])->update(['is_public' => false]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->boolean('is_public')->default(true)->change();
        });
    }
};

