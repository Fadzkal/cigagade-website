<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::updateOrCreate(
    ['email' => 'admin@desacigagade.id'],
    [
        'name' => 'Super Admin Desa Cigagade',
        'password' => Hash::make('adminCigagade2026!#$'),
        'role' => 'superadmin',
    ]
);

echo "Superadmin Desa Cigagade created successfully!\n";
