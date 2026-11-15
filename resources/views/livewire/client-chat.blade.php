<div>
    <!-- Botón Flotante (Estilo WhatsApp) -->
    <button wire:click="toggleChat" class="fixed bottom-6 right-6 bg-gradient-to-r from-brand-purple to-brand-cyan text-white p-4 rounded-full shadow-2xl hover:scale-110 transition duration-300 z-50 flex items-center justify-center">
        @if($isOpen)
            <!-- Icono de Cerrar (X) -->
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        @else
            <!-- Icono de Chat -->
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
        @endif
    </button>

    <!-- Ventanita del Chat -->
    @if($isOpen)
        <div wire:poll.3s class="fixed bottom-24 right-6 w-80 sm:w-96 bg-gray-900 border border-white/10 rounded-2xl shadow-2xl overflow-hidden z-50 flex flex-col" style="height: 450px;">
            
            <!-- Cabecera -->
            <div class="bg-white/5 p-4 border-b border-white/10 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-brand-purple to-brand-cyan flex items-center justify-center text-white font-bold">S</div>
                <div>
                    <h3 class="text-white font-bold">Soporte Subli-Arte</h3>
                    <p class="text-xs text-green-400 flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-green-400"></span> En línea
                    </p>
                </div>
            </div>

            <!-- Área de Mensajes -->
            <div class="flex-1 p-4 overflow-y-auto bg-gray-800 flex flex-col space-y-3" id="chat-container">
                <div class="text-center text-xs text-gray-500 mb-2">
                    ¡Hola! ¿En qué podemos ayudarte con tu diseño?
                </div>

                @foreach($messages as $msg)
                    <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[80%] rounded-xl px-3 py-2 text-sm {{ $msg->sender_id === auth()->id() ? 'bg-brand-purple text-white rounded-br-none' : 'bg-white/10 text-gray-200 rounded-bl-none border border-white/5' }}">
                            {{ $msg->body }}
                            <div class="text-[9px] text-right mt-1 opacity-60">{{ $msg->created_at->format('h:i A') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Caja de Texto -->
            <div class="p-3 bg-gray-900 border-t border-white/10">
                <form wire:submit="sendMessage" class="flex items-center gap-2">
                    <input type="text" 
                           wire:model="messageBody" 
                           placeholder="Escribe tu mensaje..." 
                           class="flex-1 bg-white/5 border border-white/10 rounded-full px-4 py-2 text-sm text-white focus:outline-none focus:border-brand-cyan">
                    <button type="submit" class="bg-brand-cyan text-gray-900 p-2 rounded-full hover:bg-cyan-400 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>