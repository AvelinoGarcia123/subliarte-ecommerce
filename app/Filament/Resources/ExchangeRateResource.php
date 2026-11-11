<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExchangeRateResource\Pages;
use App\Models\ExchangeRate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExchangeRateResource extends Resource
{
    protected static ?string $model = ExchangeRate::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Tasa de Cambio (BCV)';
    protected static ?string $title = 'Historial de Tasa de Cambio';
    protected static ?string $slug = 'tasa-cambio';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Registrar Nueva Tasa')
                    ->description('Ingresa el nuevo valor del dólar. Al guardarlo como activo, la tasa anterior se desactivará.')
                    ->schema([
                        Forms\Components\TextInput::make('rate')
                            ->label('Tasa (Bs. por Dólar)')
                            ->numeric()
                            ->prefix('Bs.')
                            ->required()
                            ->helperText('Ejemplo: 36.50'),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label('¿Es la tasa actual?')
                            ->default(true)
                            ->helperText('Si lo activas, esta será la tasa que se use en la tienda.'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rate')
                    ->label('Tasa en Bolívares')
                    ->money('VES')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Estado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Registro')
                    ->dateTime('d/m/Y h:i A')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc') // Las más nuevas primero
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Solo tasa activa')
                    ->placeholder('Todas')
                    ->trueLabel('Activas')
                    ->falseLabel('Inactivas'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListExchangeRates::route('/'),
            'create' => Pages\CreateExchangeRate::route('/create'),
            'edit' => Pages\EditExchangeRate::route('/{record}/edit'),
        ];
    }
}
