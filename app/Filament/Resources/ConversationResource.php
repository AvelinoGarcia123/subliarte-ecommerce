<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConversationResource\Pages;
use App\Models\Conversation;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class ConversationResource extends Resource
{
    protected static ?string $model = Conversation::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Mensajes (Chat)';
    protected static ?string $title = 'Bandeja de Mensajes';
    
    // ✅ ESTA ES LA LÍNEA MÁGICA QUE LO OCULTA DEL MENÚ LATERAL
    protected static bool $shouldRegisterNavigation = false; 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Chat con el Cliente')
                    ->schema([
                        Forms\Components\Placeholder::make('cliente')
                            ->label('Cliente')
                            ->content(fn ($record) => $record ? $record->user->name : 'Nuevo'),
                        
                        // Aquí mostraremos los mensajes (esto es visual para el administrador)
                        Forms\Components\View::make('filament.forms.chat-messages')
                            ->viewData(fn ($record) => ['messages' => $record ? $record->messages : []]),

                        // Campo para responder
                        Forms\Components\Textarea::make('new_message')
                            ->label('Escribe tu respuesta...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('messages_count')
                    ->counts('messages')
                    ->label('Mensajes Totales')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('last_message_at')
                    ->label('Último Mensaje')
                    ->dateTime('d/m/Y h:i A')
                    ->sortable(),
            ])
            ->defaultSort('last_message_at', 'desc')
            ->actions([
                Tables\Actions\Action::make('abrir_chat')
                    ->label('Abrir Chat')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('primary')
                    ->url(fn (Conversation $record) => static::getUrl('edit', ['record' => $record])),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConversations::route('/'),
            'edit' => Pages\EditConversation::route('/{record}/edit'),
        ];
    }
}