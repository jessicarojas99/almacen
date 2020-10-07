<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    //
    protected $fillable = [
        'item', 'description', 'brand', 'code', 'color', 'quantity'
    ];
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];
}
