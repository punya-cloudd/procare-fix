<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BouchardDetail extends Model
{
    use HasFactory;

    protected $table = 'bouchard_detail';

    protected $fillable = [

        'bouchard_id',

        'jam',

        'm00',
        'm15',
        'm30',
        'm45',

    ];

    protected $casts = [

        'jam' => 'integer',

        'm00' => 'integer',
        'm15' => 'integer',
        'm30' => 'integer',
        'm45' => 'integer',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function bouchard()
    {
        return $this->belongsTo(
            Bouchard::class,
            'bouchard_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    public function getTotalIntervalAttribute()
    {
        return collect([
            $this->m00,
            $this->m15,
            $this->m30,
            $this->m45
        ])->filter()->count();
    }

    public function getKategoriAttribute()
    {
        return [
            '00-15' => $this->m00,
            '15-30' => $this->m15,
            '30-45' => $this->m30,
            '45-60' => $this->m45,
        ];
    }

    public static function kategoriBouchard()
    {
        return [
            1 => ['aktivitas' => 'Tidur / Berbaring', 'energi' => 0.26],
            2 => ['aktivitas' => 'Duduk', 'energi' => 0.30],
            3 => ['aktivitas' => 'Berdiri', 'energi' => 0.38],
            4 => ['aktivitas' => 'Berjalan / Aktivitas Ringan', 'energi' => 0.57],
            5 => ['aktivitas' => 'Pekerjaan Manual Ringan', 'energi' => 0.83],
            6 => ['aktivitas' => 'Olahraga Ringan', 'energi' => 1.00],
            7 => ['aktivitas' => 'Pekerjaan Manual Sedang', 'energi' => 1.20],
            8 => ['aktivitas' => 'Olahraga Sedang', 'energi' => 1.40],
            9 => ['aktivitas' => 'Olahraga Berat', 'energi' => 1.95],
        ];
    }

    public function energi($kategori)
    {
        return self::kategoriBouchard()[$kategori]['energi'] ?? '-';
    }

    public function aktivitas($kategori)
    {
        return self::kategoriBouchard()[$kategori]['aktivitas'] ?? '-';
    }
}
