<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Pedidos y Ventas';
    protected static ?string $title = 'Gestión de Pedidos';

    public static function form(Form $form): Form
    {
        // El formulario ahora es solo para actualizar el estado en caso de edición
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->label('Estado del Pedido')
                    ->options([
                        'pendiente' => '⏳ Pendiente de Pago',
                        'pagado' => '✅ Pagado (Comprobante Validado)',
                        'en_produccion' => '🎨 En Producción (Diseñando)',
                        'entregado' => '📦 Entregado al Cliente',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Nro.')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Cliente (Físico)')
                    ->searchable()
                    ->placeholder('N/A')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Cliente (Online)')
                    ->searchable()
                    ->placeholder('N/A')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('sale_type')
                    ->label('Canal')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'online' => 'info',
                        'fisica' => 'success',
                    }),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total ($)')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Estado')
                    ->colors([
                        'warning' => 'pendiente',
                        'success' => 'pagado',
                        'primary' => 'en_produccion',
                        'secondary' => 'entregado',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y h:i A')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Filtrar por Estado')
                    ->options([
                        'pendiente' => 'Pendientes',
                        'pagado' => 'Pagados',
                        'en_produccion' => 'En Producción',
                        'entregado' => 'Entregados',
                    ]),
                Tables\Filters\SelectFilter::make('sale_type')
                    ->label('Filtrar por Canal')
                    ->options([
                        'online' => 'Tienda Online',
                        'fisica' => 'Tienda Física',
                    ]),
            ])
            ->headerActions([
                // BOTÓN PARA VENTA FÍSICA
                Tables\Actions\Action::make('nueva_venta_fisica')
                    ->label('Nueva Venta Física')
                    ->icon('heroicon-o-plus')
                    ->color('success')
                    ->url(fn () => route('filament.admin.resources.orders.create', ['type' => 'fisica'])),
            ])
            ->actions([
                // BOTÓN PARA IMPRIMIR FACTURA (AHORA CON TASA BCV)
                Tables\Actions\Action::make('factura')
                    ->label('Factura')
                    ->icon('heroicon-o-printer')
                    ->color('gray')
                    ->action(function (Order $record) {
                        // Buscamos la tasa BCV activa en la base de datos
                        $activeRate = \App\Models\ExchangeRate::getActiveRate();
                        $rate = $activeRate ? $activeRate->rate : 0;
                        
                        // Cargamos la vista del PDF enviándole la orden y la tasa
                        $pdf = Pdf::loadView('reports.invoice-pdf', [
                            'order' => $record,
                            'rate' => $rate 
                        ]);
                        
                        // Descargamos el PDF
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->stream();
                        }, 'Factura_SubliArte_' . $record->id . '.pdf');
                    }),

                // BOTÓN PARA VER COMPROBANTE (SOLO ONLINE)
                Tables\Actions\Action::make('ver_comprobante')
                    ->label('Ver Pago')
                    ->icon('heroicon-o-banknotes')
                    ->color('success')
                    ->url(fn (Order $record) => $record->payment_receipt_path ? asset('storage/' . $record->payment_receipt_path) : null)
                    ->openUrlInNewTab()
                    ->visible(fn (Order $record) => $record->payment_receipt_path !== null && $record->sale_type === 'online'),

                // BOTÓN PARA EDITAR ESTADO
                Tables\Actions\EditAction::make()->label('Gestionar'),
                
                // BOTÓN PARA ELIMINAR
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'), 
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}