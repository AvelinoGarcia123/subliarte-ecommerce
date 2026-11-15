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
use Filament\Forms\Components\Placeholder;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;

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

        $order = $this->getRecord();
        
        if ($order->wasChanged('status') && $order->user_id) {
            $order->user->notify(new \App\Notifications\OrderStatusUpdated($order, $order->status));
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detalles del Cliente y Pago')
                    ->schema([
                        TextInput::make('customer_name')
                            ->label('Cliente')
                            ->disabled()
                            ->default(fn ($record) => $record?->customer_name ?? $record?->user?->name),
                            
                        TextInput::make('total')
                            ->label('Total a Pagar')
                            ->prefix('$')
                            ->disabled(),
                            
                        Select::make('status')
                            ->label('Estado del Pedido')
                            ->options([
                                'pendiente' => '⏳ Pendiente de Pago',
                                'pagado' => '✅ Pagado (Comprobante Validado)',
                                'en_produccion' => '🎨 En Producción (Diseñando)',
                                'entregado' => '📦 Entregado al Cliente',
                                'cancelado' => '❌ Cancelado',
                            ])
                            ->required(),
                    ])->columns(3),

                Section::make('Productos y Diseños a Sublimar')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->label('Producto')
                                    ->disabled(),
                                
                                TextInput::make('price')
                                    ->label('Precio Unitario')
                                    ->prefix('$')
                                    ->disabled(),
                                    
                                TextInput::make('quantity')
                                    ->label('Cantidad')
                                    ->disabled(),
                                    
                                FileUpload::make('customization_file_path')
                                    ->label('Diseño a Sublimar')
                                    ->image()
                                    ->disk('public')
                                    ->directory('disenos')
                                    ->openable()
                                    ->downloadable()
                                    ->disabled(),
                                    
                                Textarea::make('customization_notes')
                                    ->label('Notas del Cliente')
                                    ->disabled()
                                    ->columnSpanFull(),
                            ])
                            ->columns(3)
                            ->addable(false)
                            ->deletable(false),
                    ]),

                // ✅ Sección corregida: Ubicación de Entrega
                Section::make('Ubicación de Entrega (Solo Delivery)')
                    ->schema([
                        Placeholder::make('mapa')
                            ->label('Mapa de Entrega')
                            ->content(function ($record) {
                                if (!$record || !$record->latitude || !$record->longitude) {
                                    return 'Este pedido no tiene coordenadas de delivery.';
                                }
                                
                                $lat = $record->latitude;
                                $lng = $record->longitude;
                                
                                return new HtmlString("
                                    <div style='width: 100%; height: 300px; border-radius: 12px; overflow: hidden; border: 1px solid #374151;'>
                                        <iframe 
                                            width='100%' 
                                            height='100%' 
                                            frameborder='0' 
                                            style='border:0' 
                                            src='https://www.google.com/maps?q={$lat},{$lng}&hl=es&z=16&output=embed' 
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                    <p style='color: #9ca3af; font-size: 13px; margin-top: 8px;'>Coordenadas: {$lat}, {$lng}</p>
                                    <a href='https://www.google.com/maps?q={$lat},{$lng}' target='_blank' style='color: #06b6d4; font-size: 13px; text-decoration: underline;'>Abrir en Google Maps</a>
                                ");
                            }),
                    ])
                    ->visible(fn ($record) => $record && $record->shipping_method === 'delivery'),
            ]);
    }
}