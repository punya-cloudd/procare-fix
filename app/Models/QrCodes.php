<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrCodes extends Model
{
    protected $table = 'qr_codes'; // pastikan sesuai nama tabel di database

    protected $fillable = [
        'url_name',
        'qr_code_path',
    ];
}
