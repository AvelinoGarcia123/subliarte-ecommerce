<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->successNotificationTitle(null),
        ];
    }

    // ✅ Ocultamos la notificación nativa
    protected function getSavedNotification(): ?Notification
    {
        return null;
    }

    // ✅ Redirigir al índice de una vez
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }

    // ✅ Guardar mensaje para SweetAlert
    protected function afterSave(): void
    {
        session()->flash('swal_success', [
            'title' => '¡Usuario Actualizado!',
            'text' => 'Los datos del usuario se han modificado correctamente.'
        ]);
    }
}