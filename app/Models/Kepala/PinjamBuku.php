<?php

namespace App\Models\Kepala;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Kepala\Buku as BukuModel;
use App\Models\User;

class PinjamBuku extends Model
{
    use SoftDeletes;

    protected $table = 'pinjambuku';

    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'denda'
    ];

    protected $dates = [
        'tanggal_pinjam',
        'tanggal_kembali',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buku()
    {
        return $this->belongsTo(BukuModel::class, 'buku_id');
    }
}
