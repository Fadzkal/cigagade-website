<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Kolom tanggal publish yang bisa diatur manual
            $table->timestamp('published_at')->nullable()->after('image');
        });

        // Isi published_at dengan created_at untuk data yang sudah ada
        DB::table('posts')->update(['published_at' => DB::raw('created_at')]);
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('published_at');
        });
    }
};
