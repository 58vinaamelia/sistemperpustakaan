<?php

namespace App\Models\Petugas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Anggota\Pinjambuku; // 🔥 FIX relasi

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun',
        'stok',
        'foto',
        'deskripsi',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'stok' => 'integer',
    ];

    /**
     * 🔥 RELASI KE PINJAM BUKU
     */
    public function pinjambuku()
    {
        return $this->hasMany(Pinjambuku::class, 'buku_id');
    }

    /**
     * 🔥 CEK APAKAH BUKU TERSEDIA
     */
    public function isTersedia()
    {
        return $this->stok > 0;
    }

    /**
     * 🔥 KURANGI STOK (dipanggil saat disetujui)
     */
    public function kurangiStok()
    {
        if ($this->stok > 0) {
            $this->decrement('stok');
        }
    }

    /**
     * 🔥 TAMBAH STOK (saat pengembalian)
     */
    public function tambahStok()
    {
        $this->increment('stok');
    }

    /**
     * 🔥 URL FOTO
     */
    public function getFotoUrlAttribute()
    {
        return $this->foto
            ? asset('storage/' . $this->foto)
            : 'https://via.placeholder.com/150x200';
    }
}
