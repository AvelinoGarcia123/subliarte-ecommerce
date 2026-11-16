<div>
    <!-- Botón Flotante (Solo se muestra si el chat está cerrado) -->
    @if(!$isOpen)
        <button wire:click="toggleChat" class="fixed bottom-6 right-6 bg-gradient-to-r from-brand-purple to-brand-cyan text-white p-4 rounded-full shadow-2xl hover:scale-110 transition duration-300 z-50 flex items-center justify-center">
            <!-- Icono de Chat -->
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
        </button>
    @endif

    <!-- Ventanita del Chat (Estilo Facebook Messenger) -->
    @if($isOpen)
        <div wire:poll.3s class="fixed bottom-0 right-0 sm:right-6 w-full sm:w-96 bg-gray-900 border border-white/10 rounded-t-2xl shadow-2xl overflow-hidden z-[100] flex flex-col" style="height: 500px;">
            
            <!-- Cabecera con botón de cerrar -->
            <div class="bg-white/5 p-4 border-b border-white/10 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-brand-purple to-brand-cyan flex items-center justify-center text-white font-bold">S</div>
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-gray-900 rounded-full"></span>
                    </div>
                    <div>
                        <h3 class="text-white font-bold leading-tight">Soporte Subli-Arte</h3>
                        <p class="text-xs text-green-400">En línea</p>
                    </div>
                </div>
                
                <!-- Botón de Cerrar (X) -->
                <button wire:click="toggleChat" class="text-gray-400 hover:text-white hover:bg-white/10 p-2 rounded-full transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Área de Mensajes (Scroll oculto y auto-scroll) -->
            <div class="flex-1 p-4 overflow-y-auto bg-gray-800 flex flex-col space-y-3 no-scrollbar" id="chat-messages-container">
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
                        <svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Script para auto-scroll al último mensaje -->
        @script
        <script>
            const scrollToBottom = () => {
                const container = document.getElementById('chat-messages-container');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            };
            
            // Bajar al final cuando se abre el chat
            setTimeout(scrollToBottom, 100);

            // Bajar al final cada vez que Livewire actualiza (mensaje nuevo)
            Livewire.hook('morph.updated', ({ el, component }) => {
                setTimeout(scrollToBottom, 100);
            });
        </script>
        @endscript
    @endif
</div>