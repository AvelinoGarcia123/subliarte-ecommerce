<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    // ✅ Obligatorio devolver un string aquí
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        // ✅ Guardamos el mensaje en la sesión
        session()->flash('swal_success', [
            'title' => '¡Producto Registrado!',
            'text' => 'El nuevo producto se ha añadido al catálogo.'
        ]);
    }
}