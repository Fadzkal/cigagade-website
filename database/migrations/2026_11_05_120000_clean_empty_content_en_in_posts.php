<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Post;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Bersihkan kolom content_en yang hanya berisi tag kosong editor (misal: <p><br></p>)
        Post::whereNotNull('content_en')->get()->each(function ($post) {
            $raw = $post->content_en;
            $hasMedia = str_contains($raw, '<img') || str_contains($raw, '<iframe') || str_contains($raw, '<video');
            $clean = preg_replace('/[\s\x{00a0}\x{200b}]+/u', '', html_entity_decode(strip_tags($raw), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if ($clean === '' && !$hasMedia) {
                $post->update(['content_en' => null]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reversal needed for cleaning empty content
    }
};

