<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'obat_id',
        'jumlah_obat',
    ];

    // Tanda bahwa model ini **tidak punya** primary key tunggal
    protected $primaryKey = null;
    public $incrementing = false;

    // Relasi ke transaksi (order)
    public function order()
    {
        return $this->belongsTo(Transaksional::class, 'order_id');
    }

    // Relasi ke obat
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}
