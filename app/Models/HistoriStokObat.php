<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HistoriStokObat extends Model
{
    protected $table = 'histori_stok_obat';

    protected $fillable = [
        'obat_id',
        'order_id',
        'tanggal_masuk',
        'tanggal_keluar',
        'jumlah_awal',
        'jumlah_baru',
        'jumlah_akhir',
    ];

    // Relasi ke tabel Obat
    public function obat()
    {
        return $this->belongsTo(\App\Models\Obat::class, 'obat_id');
    }

    // Relasi ke tabel Order
    public function order()
    {
        return $this->belongsTo(\App\Models\TrnOrder::class, 'order_id');
    }
}
