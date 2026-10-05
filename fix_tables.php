<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasTable('settings')) {
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('key')->unique();
        $table->text('value')->nullable();
        $table->timestamps();
    });
    echo "Table 'settings' created.\n";
}

if (!Schema::hasTable('users')) {
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->string('role')->default('user'); // Added from the add_role_to_users migration
        $table->rememberToken();
        $table->timestamps();
    });
    echo "Table 'users' created.\n";
}

if (!Schema::hasTable('sessions')) {
    Schema::create('sessions', function (Blueprint $table) {
        $table->string('id')->primary();
        $table->foreignId('user_id')->nullable()->index();
        $table->string('ip_address', 45)->nullable();
        $table->text('user_agent')->nullable();
        $table->longText('payload');
        $table->integer('last_activity')->index();
    });
    echo "Table 'sessions' created.\n";
}

echo "All missing tables fixed!\n";
