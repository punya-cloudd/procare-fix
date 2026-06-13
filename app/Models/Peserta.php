<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'peserta';

    protected $fillable = [
        'no_rm',
        'nik',
        'nama',
        'jk',
        'tgl_lahir',
        'alamat',
        'no_hp',
        'diagnosa',
        'no_bpjs',
        'status'
    ];
}
