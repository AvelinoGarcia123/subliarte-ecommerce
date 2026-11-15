<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // ✅ Ocultamos la notificación nativa
    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    // ✅ CORRECCIÓN: Quitamos el '?' porque CreateRecord exige un string obligatorio
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // ✅ Guardar mensaje para SweetAlert
    protected function afterCreate(): void
    {
        session()->flash('swal_success', [
            'title' => '¡Usuario Registrado!',
            'text' => 'El nuevo usuario se ha creado correctamente.'
        ]);
    }
}