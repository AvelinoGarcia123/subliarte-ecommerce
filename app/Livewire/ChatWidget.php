<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;

class ChatWidget extends Component
{
    public $isOpen = false;
    public $unreadCount = 0;
    
    public $activeConversationId = null;
    public $activeConversationUser = null;
    public $newMessage = '';

    public function mount()
    {
        $this->updateUnreadCount();
    }

    public function updateUnreadCount()
    {
        $this->unreadCount = Message::where('is_read', false)
            ->where('sender_id', '!=', auth()->id())
            ->count();
    }

    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
        if ($this->isOpen) {
            $this->updateUnreadCount();
        }
    }

    public function openChat($conversationId)
    {
        $this->activeConversationId = $conversationId;
        $conversation = Conversation::with('user')->find($conversationId);
        
        if ($conversation && $conversation->user) {
            $this->activeConversationUser = $conversation->user->name;
        } else {
            $this->activeConversationUser = 'Cliente Desconocido';
        }

        $this->isOpen = false; 
        $this->markAsRead($conversationId);
    }

    public function closeChat()
    {
        $this->activeConversationId = null;
        $this->activeConversationUser = null;
        $this->newMessage = '';
    }

    public function markAsRead($conversationId)
    {
        Message::where('conversation_id', $conversationId)
            ->where('sender_id', '!=', auth()->id())
            ->update(['is_read' => true]);
        
        $this->updateUnreadCount();
    }

    public function sendMessage()
    {
        if (trim($this->newMessage) === '' || !$this->activeConversationId) return;

        Message::create([
            'conversation_id' => $this->activeConversationId,
            'sender_id' => auth()->id(),
            'body' => $this->newMessage,
            'is_read' => true,
        ]);

        Conversation::find($this->activeConversationId)->update(['last_message_at' => now()]);

        $this->newMessage = '';
    }

    public function render()
    {
        $conversations = Conversation::with('user')
            ->orderBy('last_message_at', 'desc')
            ->limit(5)
            ->get();

        $messages = [];
        if ($this->activeConversationId) {
            $messages = Message::where('conversation_id', $this->activeConversationId)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('livewire.chat-widget', compact('conversations', 'messages'));
    }
}