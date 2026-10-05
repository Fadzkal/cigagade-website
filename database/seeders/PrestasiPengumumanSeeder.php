<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class PrestasiPengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Prestasi', 'Pengumuman'];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat],
                ['slug' => Str::slug($cat, '-')]
            );
        }
    }
}
