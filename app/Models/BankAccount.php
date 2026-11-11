<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_id', 'bank_name', 'account_type', 'phone', 'id_number', 'account_number', 'is_active'
    ];

    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }
}