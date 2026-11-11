<div x-data="{ 
    openList: @entangle('isOpen'), 
    activeChat: @entangle('activeConversationId') 
}">
    <!-- BOTÓN DEL CHAT (CAMPANITA) -->
    <button @click="openList = !openList" type="button" class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none transition-colors duration-200">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
        
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <!-- MENÚ DESPLEGABLE (LISTA DE CHATS) -->
    <template x-teleport="body">
        <div x-show="openList" x-cloak @click.away="openList = false" 
             class="fixed bg-white dark:bg-gray-900 rounded-lg shadow-2xl border border-gray-200 dark:border-white/10 overflow-hidden" 
             style="width: 320px; top: 60px; right: 100px; z-index: 99999;">
            
            <div class="p-4 border-b border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-gray-800 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 dark:text-white text-md">Chats Recientes</h3>
                <button @click="openList = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="max-h-80 overflow-y-auto">
                @forelse($conversations as $conv)
                    <button wire:click="openChat({{ $conv->id }})" @click="openList = false" class="w-full flex items-center p-3 hover:bg-gray-100 dark:hover:bg-white/5 transition text-left border-b border-gray-100 dark:border-gray-800 last:border-0">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold mr-3 flex-shrink-0">
                            {{ substr($conv->user->name ?? 'C', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $conv->user->name ?? 'Cliente' }}</p>
                            <p class="text-xs text-gray-500 truncate mt-1">{{ $conv->last_message_at ? $conv->last_message_at->diffForHumans() : 'Nuevo chat' }}</p>
                        </div>
                    </button>
                @empty
                    <div class="p-6 text-center text-gray-500 text-sm">No hay mensajes aún.</div>
                @endforelse
            </div>
        </div>
    </template>

    <!-- VENTANA FLOTANTE DE CHAT -->
    <template x-teleport="body">
        <div x-show="activeChat" x-cloak wire:poll.3s 
             class="fixed bg-white dark:bg-gray-900 rounded-t-xl shadow-[0_0_20px_rgba(0,0,0,0.5)] border border-gray-200 dark:border-gray-700 flex flex-col overflow-hidden" 
             style="width: 328px; height: 450px; bottom: 0px; right: 20px; z-index: 999999;">
            
            @if($activeConversationId)
                <div class="bg-indigo-600 p-3 flex justify-between items-center text-white">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-white text-indigo-600 flex items-center justify-center font-bold mr-2">
                            {{ substr($activeConversationUser, 0, 1) }}
                        </div>
                        <span class="font-bold text-sm">{{ $activeConversationUser }}</span>
                    </div>
                    <button wire:click="closeChat" @click="activeChat = null" class="text-white hover:text-gray-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="flex-1 p-4 overflow-y-auto bg-gray-50 dark:bg-gray-800 flex flex-col space-y-3">
                    @forelse($messages as $msg)
                        <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[80%] rounded-lg px-3 py-2 text-sm {{ $msg->sender_id === auth()->id() ? 'bg-indigo-600 text-white rounded-br-none' : 'bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 shadow-sm rounded-bl-none border border-gray-200 dark:border-gray-600' }}">
                                {{ $msg->body }}
                                <div class="text-[9px] text-right mt-1 opacity-70">{{ $msg->created_at->format('h:i A') }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-400 text-xs my-auto">No hay mensajes aún.</div>
                    @endforelse
                </div>

                <div class="p-3 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-white/10">
                    <form wire:submit="sendMessage" class="flex items-center">
                        <input type="text" wire:model="newMessage" placeholder="Escribe un mensaje..." class="flex-1 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-full px-4 py-2 text-sm focus:outline-none focus:border-indigo-500">
                        <button type="submit" class="ml-2 bg-indigo-600 text-white p-2 rounded-full hover:bg-indigo-700 transition">
                            <svg class="w-4 h-4 transform rotate-90" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </template>
</div>