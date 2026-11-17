<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Product;

class LowStockProducts extends BaseWidget
{
    protected static ?string $heading = '⚠️ Alerta de Stock Bajo (Menos de 5)';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()->where('stock', '<', 5)->orderBy('stock', 'asc')
            )
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')->label('Foto')->circular(),
                Tables\Columns\TextColumn::make('name')->label('Producto')->weight('bold'),
                Tables\Columns\TextColumn::make('category.name')->label('Categoría')->badge()->color('info'),
                Tables\Columns\TextColumn::make('stock')->label('Stock Restante')->badge()->color('danger')->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('editar')
                    ->label('Reabastecer')
                    ->icon('heroicon-o-plus-circle')
                    ->color('warning')
                    ->url(fn (Product $record): string => route('filament.admin.resources.products.edit', $record)),
            ])
            ->emptyStateHeading('Todo en orden')
            ->emptyStateDescription('No hay productos con stock bajo en este momento.')
            ->emptyStateIcon('heroicon-o-check-badge');
    }
}