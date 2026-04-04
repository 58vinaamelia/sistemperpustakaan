<?php

namespace App\Models\Kepala; // ✅ PENTING

use Illuminate\Database\Eloquent\Model;

class PinjamBuku extends Model
{
    protected $table = 'pinjambuku';

    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'denda'
    ];
}
