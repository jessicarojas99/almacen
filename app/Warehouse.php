<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Warehouse extends Model
{
    //
    use SoftDeletes;

    //protected $dates=['deleted_at'];

    protected $fillable = [
        'item', 'description', 'brand', 'code', 'color', 'quantity'
    ];
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
    public function brands()
    {
        return $this->belongsTo(Brand::class);
    }
    public function scopeWhereItem($query,$item){
        if($item){
            return $query->where('item', '=', $item);
        }
    }
    public function scopeWhereBrand($query,$brand){
        if($brand){
            return $query->where('brand_id', '=', $brand);
        }
    }
    public function scopeWhereFrom($query,$fromdate){
        if($fromdate){

            return $query->where('created_at', '>=', $fromdate);
        }
    }
    public function scopeWhereTo($query,$todate){
        if($todate){

            return $query->where('created_at', '<=', $todate);
        }
    }
    public function scopeWhereQuantity($query,$quantity){
        if($quantity){
            return $query->where('quantity', '=', $quantity);
        }
    }
}
