<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan';

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

        // Dokumen
        'dokumen',

        'risk_score',
        'risk_level',
        'risk_breakdown',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'petugas_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
