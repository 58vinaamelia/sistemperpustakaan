<?php

namespace App\Models\Petugas;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Petugas\Buku;

class Pinjambuku extends Model
{
    protected $table = 'pinjambukus'; // sesuaikan dengan tabel kamu

    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'denda'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
