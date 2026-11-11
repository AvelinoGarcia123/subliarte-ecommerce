<div class="flex flex-col space-y-4 max-h-96 overflow-y-auto p-4 bg-gray-50 rounded-lg">
    @forelse($messages as $message)
        <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
            <div class="max-w-[75%] rounded-lg px-4 py-2 {{ $message->sender_id === auth()->id() ? 'bg-indigo-600 text-white' : 'bg-white text-gray-800 shadow border border-gray-200' }}">
                <p class="text-xs font-bold mb-1 opacity-75">{{ $message->sender->name }}</p>
                <p class="text-sm">{{ $message->body }}</p>
                <p class="text-[10px] text-right mt-1 opacity-50">{{ $message->created_at->format('h:i A') }}</p>
            </div>
        </div>
    @empty
        <div class="text-center text-gray-400 py-10">
            No hay mensajes aún. ¡Inicia la conversación!
        </div>
    @endforelse
</div>