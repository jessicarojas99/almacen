<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    //
    public function scopeWhereItem($query,$item){
        if($item && $item !== 'all'){
            return $query->where('item', '=', $item);
        }
    }
    public function scopeWhereBrand($query,$brand){
        if($brand && $brand !== 'all'){
            return $query->where('brand', '=', $brand);
        }
    }

}
