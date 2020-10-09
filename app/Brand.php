<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }
}
