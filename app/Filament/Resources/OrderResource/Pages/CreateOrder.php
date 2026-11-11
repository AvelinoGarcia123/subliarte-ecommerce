<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification; // ✅ Agregado para ocultar la nativa
use App\Models\Product;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
    protected static ?string $title = 'Registrar Venta Física (POS)';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Datos del Cliente (Mostrador)')
                    ->description('Llena estos datos para emitir una factura legal.')
                    ->schema([
                        TextInput::make('customer_name')
                            ->label('Nombre y Apellido')
                            ->required()
                            ->regex('/^[\pL\s]+$/u')
                            ->validationMessages(['regex' => 'El nombre solo puede contener letras y espacios.']),

                        TextInput::make('customer_id_number')
                            ->label('Cédula o RIF (Ej: V-12345678)')
                            ->required()
                            ->regex('/^[VEJPGvejpg]-?\d+$/')
                            ->validationMessages(['regex' => 'Formato inválido. Use V-12345678 o J-12345678.']),

                        TextInput::make('customer_phone')
                            ->label('Teléfono (Ej: 04141234567)')
                            ->numeric(),

                        TextInput::make('customer_address')
                            ->label('Dirección')
                            ->columnSpanFull(),
                    ])->columns(3),

                Section::make('Productos a Vender')
                    ->schema([
                        Repeater::make('items')
                            ->relationship('items')
                            ->label('Productos')
                            ->schema([
                                Select::make('product_id')
                                    ->label('Producto')
                                    ->options(Product::pluck('name', 'id'))
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $product = Product::find($state);
                                        if ($product) {
                                            $set('price', $product->price);
                                        }
                                    }),
                                TextInput::make('quantity')
                                    ->label('Cantidad')
                                    ->numeric()
                                    ->default(1)
                                    ->required()
                                    ->minValue(1),
                                TextInput::make('price')
                                    ->label('Precio Unitario')
                                    ->numeric()
                                    ->prefix('$')
                                    ->disabled()
                                    ->dehydrated(),
                            ])
                            ->columns(3)
                            ->required()
                            ->minItems(1),
                    ]),
            ]);
    }

    // ✅ 1. Quitamos la notificación nativa de Filament
    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id(); 
        $data['sale_type'] = 'fisica'; 
        $data['status'] = 'pagado'; 
        
        // Inicializamos el total en 0 para que el INSERT inicial no falle
        $data['total'] = 0; 

        return $data;
    }

    protected function afterCreate(): void
    {
        $total = 0;
        
        // Iteramos sobre los productos que ya se guardaron en la base de datos
        foreach ($this->record->items as $item) {
            // Sumamos el precio x cantidad
            $total += $item->price * $item->quantity;
            
            // Descontamos el stock
            $product = Product::find($item->product_id);
            if ($product) {
                $product->decrement('stock', $item->quantity);
            }
        }
        
        // Actualizamos el pedido con el total real calculado
        $this->record->update(['total' => $total]);

        // ✅ 2. Guardamos el mensaje para que SweetAlert2 lo muestre en la lista
        session()->flash('swal_success', [
            'title' => '¡Venta Registrada!',
            'text' => 'El pedido físico se ha generado y el stock se ha descontado correctamente.'
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}