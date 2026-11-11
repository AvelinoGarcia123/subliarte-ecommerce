<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;
    
    // ✅ Le decimos que use nuestra vista personalizada
    protected static string $view = 'filament.resources.product-resource.pages.list-products';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->successNotificationTitle(null),
        ];
    }
}