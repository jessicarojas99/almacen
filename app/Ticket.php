<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'code', 'responsable', 'user_id'
    ];
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];
}
