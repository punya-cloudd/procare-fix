<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksional extends Model
{
    use HasFactory;

    protected $table = 'trn_order';

    protected $fillable = [
        'unit_layanan_id',
        'user_id',
        'tgl_order',
        'jam_order',
        'status',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    protected $casts = [
        'tgl_order' => 'date',
    ];

    // Relasi ke detail transaksi
    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    // Relasi ke unit layanan
    public function unitLayanan()
    {
        return $this->belongsTo(UnitLayanan::class, 'unit_layanan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
    
}
