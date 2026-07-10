<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPenyakit extends Model
{
    use HasFactory;

    protected $table = 'jenis_penyakit';

    protected $fillable = [
        'kode',
        'nama_penyakit',
        'keterangan',
        'status',
    ];

    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'jenis_penyakit_id');
    }
}