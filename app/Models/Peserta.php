<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'peserta';

    protected $fillable = [
        'no_rm',
        'no_bpjs',
        'nik',
        'nama',
        'jk',
        'tgl_lahir',
        'alamat',
        'no_hp',
        'dokter_id',
        'jenis_penyakit_id',
        'status',
    ];

    /**
     * Relasi ke Master Dokter
     */
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    /**
     * Relasi ke Master Jenis Penyakit
     */
    public function jenisPenyakit()
    {
        return $this->belongsTo(JenisPenyakit::class, 'jenis_penyakit_id');
    }

    /**
     * Relasi Pemeriksaan
     */
    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class, 'peserta_id');
    }

    /**
     * Relasi Pemeriksaan Lab
     */
    // public function pemeriksaanLab()
    // {
    //     return $this->hasMany(PemeriksaanLab::class, 'peserta_id');
    // }

    /**
     * Relasi Home Visit
     */
    public function homeVisit()
    {
        return $this->hasMany(HomeVisit::class, 'peserta_id');
    }

    public function monitoringMakanan()
    {
        return $this->hasMany(MonitoringMakanan::class, 'peserta_id');
    }
    public function bouchard()
    {
        return $this->hasMany(Bouchard::class, 'peserta_id');
    }
    
    public function user()
    {
        return $this->hasOne(User::class, 'peserta_id');
    }
}
