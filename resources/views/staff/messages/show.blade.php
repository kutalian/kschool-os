<x-master-layout>
    <div class="fade-in pb-12">
        <div class="mb-6 flex justify-between items-start">
            <div>
                <a href="{{ route('staff.messages.index') }}"
                    class="text-indigo-600 hover:text-indigo-700 text-sm font-medium mb-2 inline-block">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Inbox
                </a>
                <h1 class="text-2xl font-bold text-gray-800">{{ $message->subject }}</h1>
                <p class="text-sm text-gray-500">
                    From: <span class="font-bold text-indigo-600">{{ $message->sender->name }}</span>
                    on {{ $message->created_at->format('M d, Y @ h:i A') }}
                </p>
            </div>

            <div class="flex gap-2">
                @if($message->receiver_id === Auth::id())
                    <a href="{{ route('staff.messages.create', ['reply_to' => $message->id]) }}"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center gap-2">
                        <i class="fas fa-reply text-sm"></i>
                        Reply
                    </a>
                @endif
                <a href="{{ route('staff.messages.delete', $message) }}"
                    class="px-4 py-2 bg-red-50 text-red-600 border border-red-100 rounded-lg hover:bg-red-100 transition flex items-center gap-2">
                    <i class="fas fa-trash text-sm"></i>
                    Delete
                </a>
            </div>
        </div>

        <div class="max-w-4xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 min-h-[300px]">
                <div class="prose max-w-none text-gray-700 whitespace-pre-wrap">{{ $message->message }}</div>
            </div>
        </div>
    </div>
</x-master-layout>