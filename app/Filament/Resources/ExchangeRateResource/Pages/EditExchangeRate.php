<?php

namespace App\Filament\Resources\ExchangeRateResource\Pages;

use App\Filament\Resources\ExchangeRateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditExchangeRate extends EditRecord
{
    protected static string $resource = ExchangeRateResource::class;
    
    // ✅ Usamos la vista personalizada
    protected static string $view = 'filament.resources.exchange-rate-resource.pages.edit-exchange-rate';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->successNotificationTitle(null),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return null;
    }

    // ✅ Redirigir al índice de una vez
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        // ✅ Guardamos el mensaje en la sesión
        session()->flash('swal_success', [
            'title' => '¡Tasa Actualizada!',
            'text' => 'La nueva tasa de cambio se ha guardado correctamente.'
        ]);
    }
}