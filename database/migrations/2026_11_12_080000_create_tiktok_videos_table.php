<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiktok_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('tiktok_url');
            $table->string('video_id')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiktok_videos');
    }
};
