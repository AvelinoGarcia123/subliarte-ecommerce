<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_id_number',
        'customer_phone',
        'customer_address',
        'total',
        'status',
        'payment_receipt_path',
        'sale_type',
        'shipping_method',
        'shipping_details',
        'shipping_cost',
        'latitude',   // ✅ Nuevo
        'longitude',  // ✅ Nuevo
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}