<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringMakananDetail extends Model
{
    use HasFactory;

    protected $table = 'monitoring_makanan_detail';

    protected $fillable = [

        'monitoring_makanan_id',

        'waktu_makan',

        'nama_makanan',

        'jumlah',

        'satuan',

        'kalori',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function monitoring()
    {
        return $this->belongsTo(
            MonitoringMakanan::class,
            'monitoring_makanan_id'
        );
    }
}