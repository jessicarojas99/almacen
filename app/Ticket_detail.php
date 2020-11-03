<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket_detail extends Model
{
    protected $fillable = [
        'quantity', 'ticket_id', 'warehouse_id'
    ];
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];
}
