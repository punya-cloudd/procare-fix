<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'm_obat'; 

    protected $fillable = [
        'nama_obat', 'satuan_id', 'gudang_id', 'stok', 'jenis_obat',
        'tanggal_kadaluarsa', 'bpom', 'gambar_obat', 'keterangan',
        'created_by', 'updated_by'
    ];

    // Relasi
    public function satuan()
    {
        return $this->belongsTo(SatuanObat::class, 'satuan_id');
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }

    public function histories()
    {
        return $this->hasMany(HistoriStokObat::class, 'obat_id');
    }
}
