<?php

namespace App\Models\Petugas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Petugas\Buku;

class Pinjambuku extends Model
{
    use SoftDeletes;

    protected $table = 'pinjambuku';

    protected $fillable = [
        'nama',
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo', // 🔥 WAJIB ADA
        'tanggal_kembali',
        'status',
        'denda'
    ];

    protected $dates = [
        'deleted_at'
    ];

    /**
     * 🔗 RELASI KE USER
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 🔗 RELASI KE BUKU
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
