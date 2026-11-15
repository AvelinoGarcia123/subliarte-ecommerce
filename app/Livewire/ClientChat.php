<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ClientChat extends Component
{
    public $isOpen = false;
    public $messageBody = '';
    public $conversation = null;
    public $messages = [];

    public function mount()
    {
        if (Auth::check()) {
            $this->loadConversation();
        }
    }

    public function loadConversation()
    {
        // Buscamos la conversación del cliente logueado o la creamos
        $this->conversation = Conversation::firstOrCreate(
            ['user_id' => Auth::id()],
            ['last_message_at' => now()]
        );

        $this->loadMessages();
    }

    public function loadMessages()
    {
        if ($this->conversation) {
            $this->messages = Message::where('conversation_id', $this->conversation->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }
    }

    public function toggleChat()
    {
        // Si no está logueado, lo mandamos al login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->isOpen = !$this->isOpen;
        
        if ($this->isOpen) {
            $this->loadConversation();
            $this->markAsRead();
        }
    }

    public function markAsRead()
    {
        if ($this->conversation) {
            Message::where('conversation_id', $this->conversation->id)
                ->where('sender_id', '!=', Auth::id())
                ->update(['is_read' => true]);
        }
    }

    public function sendMessage()
    {
        if (trim($this->messageBody) === '' || !$this->conversation) return;

        Message::create([
            'conversation_id' => $this->conversation->id,
            'sender_id' => Auth::id(),
            'body' => $this->messageBody,
            'is_read' => false, // Para que al admin le salga la notificación
        ]);

        $this->conversation->update(['last_message_at' => now()]);

        $this->messageBody = '';
        $this->loadMessages();
    }

    public function render()
    {
        // Refrescamos los mensajes si el chat está abierto
        if ($this->isOpen) {
            $this->loadMessages();
            // Marcamos como leídos los mensajes del admin mientras el cliente tiene la ventana abierta
            $this->markAsRead(); 
        }

        return view('livewire.client-chat');
    }
}