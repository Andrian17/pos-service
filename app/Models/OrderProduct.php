<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'product_id'
            /** your key */
            ,
            'id'
            /** Product Key */
        );
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
