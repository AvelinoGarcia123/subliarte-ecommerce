<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;
    protected static string $view = 'filament.resources.product-resource.pages.edit-product';

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

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        // ✅ Guardamos el mensaje en la sesión
        session()->flash('swal_success', [
            'title' => '¡Producto Actualizado!',
            'text' => 'El producto se ha modificado correctamente.'
        ]);
    }

/*    protected function afterSave(): void
    {
        $this->dispatch('swal:success', [
            'title' => '¡Producto Actualizado!',
            'text' => 'El producto se ha modificado correctamente.'
        ]);
    }*/
}