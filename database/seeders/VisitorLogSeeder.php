<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VisitorLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fresh start: no mock data seeded.
        // Visits are logged purely in real-time by TrackVisitor middleware.
    }
}
