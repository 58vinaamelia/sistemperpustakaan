<?php

namespace App\Models\Anggota;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Petugas\Buku;
use App\Models\User;

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
        'status',
        'kondisi_buku',
    ];

    // =========================
    // RELASI KE BUKU
    // =========================
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    // =========================
    // RELASI KE USER
    // =========================
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // =========================
    // RELASI KE PEMINJAMAN
    // =========================
    public function peminjaman()
    {
        return $this->belongsTo(Pinjambuku::class, 'buku_id', 'buku_id');
    }
}
