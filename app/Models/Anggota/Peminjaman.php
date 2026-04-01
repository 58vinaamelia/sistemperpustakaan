<?php

namespace App\Models\Anggota;

use Illuminate\Database\Eloquent\Model;
use App\Models\Anggota\Buku;

class Peminjaman extends Model
{
    protected $table = 'peminjaman'; // nama tabel

    protected $fillable = [
        'nama',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'status'
    ];

    // 🔥 relasi ke buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
