<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeVisit extends Model
{
    protected $table = 'home_visit';

    protected $guarded = [];

    protected $casts = [
        'tanggal' => 'date',
        'berat_badan' => 'decimal:2',
        'tinggi_badan' => 'decimal:2',
        'bmi' => 'decimal:2',
    ];

    // =====================
    // RELASI
    // =====================

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'petugas_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // =====================
    // ACCESSOR
    // =====================

    public function getTekananDarahAttribute()
    {
        if ($this->sistol && $this->diastol) {
            return $this->sistol . '/' . $this->diastol;
        }

        return '-';
    }
}