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
        'petugas_tambahan',
        'tanggal',

        'keluhan_utama',
        'hamil',
        'menyusui',
        'status_perokok',

        'riwayat_penyakit',
        'riwayat_alergi_obat',
        'riwayat_alergi_lainnya',
        'obat_dikonsumsi',

        'suhu',
        'sistol',
        'diastol',
        'nadi',
        'respirasi',
        'spo2',

        'berat_badan',
        'tinggi_badan',
        'bmi',
        'lingkar_perut',

        'kepatuhan',

        'gds',
        'gdp',
        'g2jpp',
        'hba1c',

        'kolesterol_total',
        'ldl',
        'hdl',
        'trigliserida',

        'ureum',
        'kreatinin',
        'egfr',
        'asam_urat',

        'hasil_lab',
        'catatan',
        'catatan_dokter',
        'catatan_gizi',
        'aktivitas_fisik',
        
        'dokumen',

        'risk_score',
        'risk_level',
        'risk_breakdown',
    ];

    protected $casts = [

        'petugas_tambahan' => 'array',
        'tanggal' => 'date',

        'hamil' => 'boolean',
        'menyusui' => 'boolean',

        'riwayat_penyakit' => 'array',
        'risk_breakdown' => 'array',

        'berat_badan' => 'decimal:2',
        'tinggi_badan' => 'decimal:2',
        'bmi' => 'decimal:2',
        'lingkar_perut' => 'decimal:2',

        'suhu' => 'decimal:1',
        'hba1c' => 'decimal:2',
        'kreatinin' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

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
