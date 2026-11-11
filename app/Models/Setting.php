<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'pm_banco',
        'pm_telefono',
        'pm_cedula_rif',
        'whatsapp',
        'instagram',
        'facebook',
        'promociones',
    ];

    // ✅ RELACIÓN: Una configuración puede tener muchas cuentas bancarias
    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }
}