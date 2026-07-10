<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'no_bpjs',
        'nik',
        'nama',
        'jk',
        'tgl_lahir',
        'alamat',
        'telepon',
        'jenis_penyakit_id',
        'status',
    ];

    public function jenisPenyakit()
    {
        return $this->belongsTo(JenisPenyakit::class);
    }

    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class);
    }

    // public function obat()
    // {
    //     return $this->hasMany(Obat::class);
    // }

    public function homeVisit()
    {
        return $this->hasMany(HomeVisit::class);
    }
}