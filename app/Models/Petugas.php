<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'petugas';

    protected $fillable = [
        'nama',
        'jabatan',
        'telepon',
        'alamat',
        'status',
    ];

    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class, 'petugas_id');
    }

    public function homeVisit()
    {
        return $this->hasMany(HomeVisit::class, 'petugas_id');
    }

    public function monitoringMakanan()
    {
        return $this->hasMany(MonitoringMakanan::class, 'petugas_id');
    }
    public function bouchard()
    {
        return $this->hasMany(Bouchard::class, 'petugas_id');
    }
}
