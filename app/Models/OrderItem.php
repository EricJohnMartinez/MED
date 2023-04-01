<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable =[
        'price',
        'quantity',
        'product_id',
        'order_id',
        'name',
        'room_number',
        'doctor',
        'nurse',
        'product_name',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
