<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    
    protected static ?string $navigationLabel = 'Productos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Categoría')
                    ->required()
                    ->preload(),

                Forms\Components\TextInput::make('name')
                    ->label('Nombre del Producto')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('price')
                    ->label('Precio')
                    ->numeric()
                    ->prefix('$') // Puedes cambiarlo a 'Bs.' si prefieres
                    ->required(),

                Forms\Components\TextInput::make('stock')
                    ->label('Stock (Cantidad)')
                    ->numeric()
                    ->default(0)
                    ->required(),

                Forms\Components\FileUpload::make('image_path')
                    ->label('Imagen del Producto')
                    ->image()
                    ->directory('productos')
                    ->required(),

                Forms\Components\Toggle::make('is_customizable')
                    ->label('¿Permite subir diseño personalizado?')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Foto'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Producto')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoría')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Precio')
                    ->money('USD') // Laravel lo mostrará con formato
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_customizable')
                    ->label('Personalizable')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->successNotificationTitle(null), // ✅ Apaga la notificación nativa
                Tables\Actions\DeleteAction::make()
                    ->successNotificationTitle(null), // ✅ Apaga la notificación nativa
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}