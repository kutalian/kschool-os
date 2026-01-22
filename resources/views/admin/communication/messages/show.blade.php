<x-master-layout>
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Read Message</h1>
            <a href="{{ route('messages.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Back to Inbox
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-start mb-6 border-b pb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $message->subject }}</h2>
                        <div class="mt-2 text-sm text-gray-600">
                            <span class="font-medium text-gray-900">From:</span> {{ $message->sender->name }}
                            ({{ $message->sender->role }})
                        </div>
                        <div class="text-sm text-gray-600">
                            <span class="font-medium text-gray-900">To:</span> {{ $message->receiver->name }}
                        </div>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $message->created_at->format('M d, Y h:i A') }}
                    </div>
                </div>

                <div class="prose max-w-none text-gray-800 mb-8 whitespace-pre-wrap">
                    {{ $message->message }}
                </div>

                <div class="flex justify-end space-x-3 mt-8 pt-4 border-t">
                    <form action="{{ route('messages.destroy', $message->id) }}" method="POST"
                        onsubmit="return confirm('Delete this message?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-100 text-red-700 hover:bg-red-200 px-4 py-2 rounded-lg font-medium transition duration-200">
                            <i class="fas fa-trash mr-2"></i> Delete
                        </button>
                    </form>
                    <a href="{{ route('messages.create', ['reply_to' => $message->id]) }}"
                        class="bg-indigo-600 text-white hover:bg-indigo-700 px-4 py-2 rounded-lg font-medium transition duration-200">
                        <i class="fas fa-reply mr-2"></i> Reply
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-master-layout>