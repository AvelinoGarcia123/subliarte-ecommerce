<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',       // <--- NUEVO
        'customer_id_number',  // <--- NUEVO
        'customer_phone',      // <--- NUEVO
        'customer_address',    // <--- NUEVO
        'total',
        'status',
        'payment_receipt_path',
        'sale_type',
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