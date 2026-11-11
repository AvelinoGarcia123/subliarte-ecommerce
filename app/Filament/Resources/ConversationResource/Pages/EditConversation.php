<?php

namespace App\Filament\Resources\ConversationResource\Pages;

use App\Filament\Resources\ConversationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Message;
use Filament\Notifications\Notification;

class EditConversation extends EditRecord
{
    protected static string $resource = ConversationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // Este método se ejecuta al guardar el formulario
    protected function afterSave(): void
    {
        $data = $this->form->getState();
        
        // Si el administrador escribió una respuesta
        if (!empty($data['new_message'])) {
            Message::create([
                'conversation_id' => $this->record->id,
                'sender_id' => auth()->id(), // El admin
                'body' => $data['new_message'],
                'is_read' => true, // El admin ya lo leyó al enviarlo
            ]);

            // Actualizar la fecha del último mensaje
            $this->record->update(['last_message_at' => now()]);

            Notification::make()
                ->title('Mensaje enviado')
                ->success()
                ->send();
                
            // Recargar la página para ver el mensaje nuevo
            $this->redirect(static::getUrl('edit', ['record' => $this->record]));
        }
    }
}