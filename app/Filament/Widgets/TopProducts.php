<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class TopProducts extends BaseWidget
{
    protected static ?string $heading = 'Top 5 - Productos Más Vendidos';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // ✅ CORRECCIÓN: Agregamos el 'id' a la consulta para que Filament no falle
                OrderItem::query()
                    ->select('id', 'product_id', DB::raw('SUM(quantity) as total_vendido'))
                    ->groupBy('id', 'product_id')
                    ->orderByDesc('total_vendido')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Producto')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('product.category.name')
                    ->label('Categoría'),
                    
                Tables\Columns\TextColumn::make('total_vendido')
                    ->label('Cantidad Vendida')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('product.price')
                    ->label('Precio Unitario')
                    ->money('USD'),
            ]);
    }
}