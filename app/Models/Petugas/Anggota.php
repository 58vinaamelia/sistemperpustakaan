<?php

namespace App\Models\Petugas;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Anggota extends Authenticatable
{
    protected $table = 'anggota'; // nama tabel di database

    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = false; // 🔥 WAJIB (biar tidak error lagi)
}
