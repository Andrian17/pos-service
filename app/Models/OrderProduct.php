<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $hidden = [
        "created_at", "updated_at"
    ];

    public function product()
    {
        return $this->belongsTo(
            // True
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
