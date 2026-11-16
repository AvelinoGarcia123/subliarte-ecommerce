<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                // ✅ VALIDACIÓN ESTRICTA: Solo letras (incluyendo acentos y ñ), espacios y guiones
                'regex:/^[\pL\s\-]+$/u', 
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email', // ✅ Asegura que sea un correo electrónico válido
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'El nombre solo puede contener letras, espacios y guiones (sin números).',
            'email.email' => 'Debes ingresar un correo electrónico válido (ejemplo: correo@dominio.com).',
        ];
    }
}