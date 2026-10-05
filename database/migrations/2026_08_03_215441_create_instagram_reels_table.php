<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instagram_reels', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('instagram_url');
            $table->string('reel_id')->nullable(); // extracted reel ID
            $table->string('thumbnail')->nullable(); // custom thumbnail upload
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instagram_reels');
    }
};
