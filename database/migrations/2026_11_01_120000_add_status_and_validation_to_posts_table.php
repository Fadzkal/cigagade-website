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
        Schema::table('posts', function (Blueprint $table) {
            $table->enum('status', ['published', 'pending', 'rejected'])
                  ->default('published')
                  ->index()
                  ->after('image');
            $table->text('rejection_note')->nullable()->after('status');
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete()->after('rejection_note');
            $table->timestamp('validated_at')->nullable()->after('validated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['validated_by']);
            $table->dropColumn(['status', 'rejection_note', 'validated_by', 'validated_at']);
        });
    }
};
