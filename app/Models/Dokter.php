<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';

    protected $fillable = [
        'nama',
        'sip',
        'spesialis',
        'telepon',
        'alamat',
        'status',
    ];

    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'dokter_id');
    }
}