<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'item', 'name'
    ];
    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }
}
