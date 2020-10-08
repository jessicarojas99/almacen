<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    //
    use SoftDeletes;

    //protected $dates=['deleted_at'];

    protected $fillable = [
        'item', 'description', 'brand', 'code', 'color', 'quantity'
    ];
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    public function brands()
    {
        return $this->belongsTo(Brand::class);
    }
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
    public function scopeWhereFechaInicio($query,$brand){
        if($brand && $brand !== 'all'){
            return $query->where('brand', '=', $brand);
        }
    }
    public function scopeWhereFechaFIn($query,$brand){
        if($brand && $brand !== 'all'){
            return $query->where('brand', '=', $brand);
        }
    }
}
