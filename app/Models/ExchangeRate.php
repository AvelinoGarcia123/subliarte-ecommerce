<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate',
        'is_active',
    ];

    // Lógica: Si guardas una tasa activa, desactiva las demás automáticamente
    protected static function booted()
    {
        static::saving(function ($exchangeRate) {
            if ($exchangeRate->is_active) {
                static::where('id', '!=', $exchangeRate->id)->update(['is_active' => false]);
            }
        });
    }

    // Función de ayuda para obtener la tasa del día
    public static function getActiveRate()
    {
        return static::where('is_active', true)->latest()->first();
    }
}