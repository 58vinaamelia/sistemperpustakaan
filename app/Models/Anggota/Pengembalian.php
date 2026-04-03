<?php

namespace App\Models\Anggota;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian';

    protected $fillable = [
        'nama',
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali',
        'denda',
        'status', // ✅ tambahkan status
    ];

    // Relasi ke Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    // Relasi ke Peminjaman (Pinjambuku) berdasarkan user dan buku
    public function peminjaman()
    {
        return $this->belongsTo(Pinjambuku::class, 'buku_id', 'buku_id')
                    ->whereColumn('user_id', 'pengembalian.user_id');
    }
}
