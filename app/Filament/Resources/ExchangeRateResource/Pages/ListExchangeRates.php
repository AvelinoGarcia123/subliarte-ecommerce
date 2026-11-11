<?php

namespace App\Filament\Resources\ExchangeRateResource\Pages;

use App\Filament\Resources\ExchangeRateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExchangeRates extends ListRecords
{
    protected static string $resource = ExchangeRateResource::class;

    // ✅ Usamos la vista personalizada para el índice
    protected static string $view = 'filament.resources.exchange-rate-resource.pages.list-exchange-rates';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->successNotificationTitle(null),
        ];
    }
}
