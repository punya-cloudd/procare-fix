<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringMakanan extends Model
{
    use HasFactory;

    protected $table = 'monitoring_makanan';

    protected $fillable = [
        'peserta_id',
        'petugas_id',
        'tanggal',
        'total_kalori',
        'catatan',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }

    public function detail()
    {
        return $this->hasMany(MonitoringMakananDetail::class, 'monitoring_makanan_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
