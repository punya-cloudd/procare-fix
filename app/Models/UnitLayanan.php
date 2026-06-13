<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitLayanan extends Model
{
    use HasFactory;

    // Define the table name (optional if your table name follows convention)
    protected $table = 'm_unit_layanan';

    // Define the fillable attributes (optional)
    protected $fillable = ['unit_layanan', 'keterangan'];
    
}
