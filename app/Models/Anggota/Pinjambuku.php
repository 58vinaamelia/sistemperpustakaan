<?php

namespace App\Models\Anggota;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Petugas\Buku;

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
        'tanggal_kembali', // ✅ penting untuk laporan
        'denda',
        'status'
    ];

    // ✅ RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ✅ RELASI KE BUKU
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    // ✅ OPTIONAL: biar tanggal otomatis format Carbon
    protected $dates = [
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali'
    ];
}
