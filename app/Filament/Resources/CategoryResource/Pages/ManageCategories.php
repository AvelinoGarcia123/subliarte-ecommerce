<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Notifications\Notification;

class ManageCategories extends ManageRecords
{
    protected static string $resource = CategoryResource::class;
    
    // ✅ Usamos una vista personalizada
    protected static string $view = 'filament.resources.category-resource.pages.manage-categories';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->successNotificationTitle(null) // ✅ Apaga la notificación nativa
                ->after(function () {
                    $this->dispatch('swal:success', [
                        'title' => '¡Categoría Creada!',
                        'text' => 'La nueva categoría se ha registrado correctamente.'
                    ]);
                }),
        ];
    }

    // ✅ Ocultamos las notificaciones nativas de Filament
    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function getSavedNotification(): ?Notification
    {
        return null;
    }
}