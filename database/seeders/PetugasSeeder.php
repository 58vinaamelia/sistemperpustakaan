<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PetugasSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Petugas',
            'email' => 'petugas@perpus.com',
            'password' => Hash::make('12345678'), // password default
            'role' => 'petugas',
        ]);

        $this->command->info('Akun petugas berhasil dibuat: petugas@perpus.com / 12345678');
    }
}
