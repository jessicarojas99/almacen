<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'warehouse_id', 'quantity'
    ];
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];
}
