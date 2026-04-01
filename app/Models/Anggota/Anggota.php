<?php

namespace App\Models\Anggota;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';

    public $timestamps = false; // ⭐ FIX ERROR

    protected $fillable = [
        'nama',
        'email',
        'password'
    ];

    protected $hidden = [
        'password'
    ];
}
