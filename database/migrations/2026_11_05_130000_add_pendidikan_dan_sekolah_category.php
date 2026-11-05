<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Category::firstOrCreate(
            ['slug' => 'pendidikan-sekolah'],
            ['name' => 'Pendidikan & Sekolah']
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Category::where('slug', 'pendidikan-sekolah')->delete();
    }
};
