<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deposit extends Model
{
    //
    public function scopeWhereItem($query, $item)
    {
        if ($item && $item !== 'all') {
            return $query->where('item', '=', $item);
        }
    }
    public function scopeWhereBrand($query, $brand)
    {
        if ($brand && $brand !== 'all') {
            return $query->where('brand', '=', $brand);
        }
    }

    use SoftDeletes;
    protected $fillable = [
        'item', 'description', 'brand_id', 'code', 'size', 'processor', 'condition', 'state', 'reason'
    ];
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    public function brands()
    {
        return $this->belongsTo(Brand::class);
    }
}
