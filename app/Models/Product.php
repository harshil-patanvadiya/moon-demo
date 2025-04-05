<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'order_id',
        'name',
        'quantity',
        'amount',
        'total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
