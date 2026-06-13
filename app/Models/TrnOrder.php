<?php
// app/Models/TrnOrder.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrnOrder extends Model
{
    use HasFactory;

    protected $table = 'trn_order'; // specify the table name if it's not following Laravel's convention
    protected $fillable = [
        'unit_layanan_id', 'user_id', 'status', 'tgl_order',
    ];

    // Define relationships (if needed)
    public function unitLayanan()
    {
        return $this->belongsTo(UnitLayanan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
