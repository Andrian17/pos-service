<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "uuid",
        "user_id",
        "payment_type_id",
        "name",
        "total_paid",
        "total_price",
        "receipt_code",
        "return"
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', "user_id");
    }

    public function order_products()
    {
        return $this->hasMany(OrderProduct::class, 'order_uuid', 'uuid');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_type_id', 'id');
    }
}
