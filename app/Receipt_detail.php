<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt_detail extends Model
{
    protected $casts = [
        'delivery_date' => 'datetime:d/m/Y',
        'return_date' => 'datetime:d/m/Y',
    ];
}
