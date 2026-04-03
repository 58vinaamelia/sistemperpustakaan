<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan model User sudah benar
use Illuminate\Support\Facades\Hash;

class KepalaSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah user kepala sudah ada
        if (!User::where('email', 'kepala@example.com')->exists()) {
            User::create([
                'name' => 'Kepala Perpustakaan',
                'email' => 'kepala@gmail.com',
                'password' => Hash::make('password123'), // password default
                'role' => 'kepala'
            ]);
        }
    }
}
