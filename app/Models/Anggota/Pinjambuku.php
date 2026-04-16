<?php

namespace App\Models\Anggota;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Petugas\Buku;

class Pinjambuku extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pinjambuku';

    protected $fillable = [
        'nama',
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali',
        'denda',
        'status',
        'alasan_ditolak'
    ];

    // =========================
    // RELASI KE USER
    // =========================
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // =========================
    // RELASI KE BUKU
    // =========================
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    // =========================
    // 🔥 RELASI KE PENGEMBALIAN (FIX TANPA ERROR)
    // =========================
    public function pengembalian()
    {
        return $this->hasOne(\App\Models\Anggota\Pengembalian::class, 'buku_id', 'buku_id');
    }

    // =========================
    // FORMAT TANGGAL
    // =========================
    protected $dates = [
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali',
        'deleted_at'
    ];
}
