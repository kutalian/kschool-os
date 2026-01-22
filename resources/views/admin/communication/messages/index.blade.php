<x-master-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Messages</h1>
            <a href="{{ route('messages.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-pen mr-2"></i> Compose
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-sm"
                role="alert">
                <strong class="font-bold"><i class="fas fa-check-circle mr-1"></i> Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            <div class="p-6 bg-white border-b border-gray-200">
                @if($messages->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sender</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Subject</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($messages as $message)
                                    <tr
                                        class="hover:bg-gray-50 transition duration-150 {{ !$message->is_read ? 'bg-indigo-50' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $message->sender->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $message->sender->role }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 font-medium">
                                                {{ $message->subject }}
                                                @if(!$message->is_read)
                                                    <span
                                                        class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">New</span>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500 truncate w-64">
                                                {{ Str::limit($message->message, 50) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $message->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('messages.show', $message->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3" title="Read"><i
                                                    class="fas fa-envelope-open"></i></a>
                                            <form action="{{ route('messages.destroy', $message->id) }}" method="POST"
                                                class="inline-block" onsubmit="return confirm('Delete this message?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Delete"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $messages->links() }}
                    </div>
                @else
                    <div class="text-center py-10">
                        <div class="mb-4">
                            <i class="fas fa-inbox text-6xl text-gray-200"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No messages yet</h3>
                        <p class="text-gray-500 mt-1">When you receive messages, they will appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-master-layout>