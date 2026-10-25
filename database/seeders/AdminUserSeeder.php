<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Let the User model's 'hashed' cast hash the password once
        User::updateOrCreate(
            ['email' => 'admin@infospare.com'],
            [
                'name' => 'Admin',
                'password' => 'admin123',
            ]
        );
    }
}
