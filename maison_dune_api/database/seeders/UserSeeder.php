<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Maison',
            'email' => 'admin@maison.test',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'name' => 'Test User One',
            'email' => 'test1@maison.test',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Test User Two',
            'email' => 'test2@maison.test',
            'password' => Hash::make('password123'),
        ]);
    }
}
