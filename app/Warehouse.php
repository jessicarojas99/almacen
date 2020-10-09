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
}
