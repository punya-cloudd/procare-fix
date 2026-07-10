<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanLab extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaanlab';

    protected $fillable = [

        'peserta_id',
        'petugas_id',

        'tanggal',

        // Tanda Vital
        'sistol',
        'diastol',
        'nadi',
        'spo2',

        // Antropometri
        'berat_badan',
        'tinggi_badan',
        'bmi',
        'lingkar_perut',

        // Keluhan
        'keluhan',
        'kepatuhan',

        // Glikemik
        'gds',
        'gdp',
        'g2jpp',
        'hba1c',

        // Profil Lipid
        'kolesterol_total',
        'ldl',
        'hdl',
        'trigliserida',

        // Fungsi Ginjal
        'ureum',
        'kreatinin',
        'egfr',
        'asam_urat',

        // Catatan
        'hasil_lab',
        'catatan',

        'risk_score',
        'risk_level',
        'risk_breakdown',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class,'peserta_id');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class,'petugas_id');
    }
}