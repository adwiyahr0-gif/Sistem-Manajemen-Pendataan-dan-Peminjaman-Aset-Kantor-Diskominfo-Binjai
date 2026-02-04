<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama agar tidak duplikat saat dijalankan ulang
        User::whereIn('email', ['admin@gmail.com', 'user@gmail.com'])->delete();

        // Buat Akun Admin
        User::create([
            'name' => 'Admin Diskominfo',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Buat Akun User
        User::create([
            'name' => 'Rabiatul Adwiyah',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }
}