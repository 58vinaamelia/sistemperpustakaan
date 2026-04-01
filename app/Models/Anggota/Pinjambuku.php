<?php

namespace App\Models\Anggota;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pinjambuku extends Model
{
    use HasFactory;

    protected $table = 'pinjambuku';

    protected $fillable = [
        'nama',
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali', // ✅ TAMBAH
        'denda',           // ✅ TAMBAH
        'status'
    ];

    // ✅ RELASI KE BUKU (FIX)
    public function buku()
    {
        return $this->belongsTo(\App\Models\Petugas\Buku::class, 'buku_id');
    }

    // ✅ RELASI USER
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
