<?php

namespace App\Filament\Resources\ExchangeRateResource\Pages;

use App\Filament\Resources\ExchangeRateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateExchangeRate extends CreateRecord
{
    protected static string $resource = ExchangeRateResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return null; // Ocultamos la nativa
    }

    protected function afterCreate(): void
    {
        $this->dispatch('swal:success', [
            'title' => '¡Tasa Registrada!',
            'text' => 'La nueva tasa de cambio está activa en el sistema.'
        ]);
    }
}