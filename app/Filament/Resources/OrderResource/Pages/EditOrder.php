<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;
    
    protected static string $view = 'filament.resources.order-resource.pages.edit-order';

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
        session()->flash('swal_success', [
            'title' => '¡Pedido Actualizado!',
            'text' => 'El estado del pedido se ha modificado correctamente.'
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detalles del Cliente y Pago')
                    ->schema([
                        TextInput::make('customer_name')
                            ->label('Cliente (Mostrador)')
                            ->disabled()
                            ->dehydrated(false)
                            ->default(fn () => $this->getRecord()?->customer_name ?? $this->getRecord()?->user?->name),
                            
                        TextInput::make('total_pagar')
                            ->label('Total a Pagar')
                            ->disabled()
                            ->dehydrated(false)
                            ->default(fn () => '$ ' . number_format($this->getRecord()?->total ?? 0, 2)),
                            
                        Select::make('status')
                            ->label('Estado del Pedido')
                            ->options([
                                'pendiente' => '⏳ Pendiente de Pago',
                                'pagado' => '✅ Pagado (Comprobante Validado)',
                                'en_produccion' => '🎨 En Producción (Diseñando)',
                                'entregado' => '📦 Entregado al Cliente',
                            ])
                            ->required(),
                    ])->columns(3),

                Section::make('Productos y Diseños a Sublimar')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                TextInput::make('producto_display')
                                    ->label('Producto')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->default(fn ($record) => $record?->product?->name . ' (x' . $record?->quantity . ')'),
                            
                                TextInput::make('price_display')
                                    ->label('Precio Unitario')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->default(fn ($record) => '$ ' . number_format($record?->price ?? 0, 2)),
                            
                                FileUpload::make('customization_file_path')
                                    ->label('Diseño a Sublimar')
                                    ->image()
                                    ->disk('public')
                                    ->directory('disenos')
                                    ->disabled(),
                            
                                Textarea::make('customization_notes')
                                    ->label('Notas del Cliente')
                                    ->disabled(),
                            ])
                            ->columns(2)
                            ->addable(false)
                            ->deletable(false),
                    ]),
            ]);
    }
}