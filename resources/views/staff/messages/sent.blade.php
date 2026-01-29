<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Sent Messages</h1>
                <p class="text-sm text-gray-500">Track your outgoing communication</p>
            </div>
            <a href="{{ route('staff.messages.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center gap-2">
                <i class="fas fa-edit text-sm"></i>
                New Message
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Tabs -->
            <div class="flex border-b border-gray-100">
                <a href="{{ route('staff.messages.index') }}"
                    class="px-6 py-4 text-sm font-medium border-b-2 transition {{ request()->routeIs('staff.messages.index') ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    Inbox
                </a>
                <a href="{{ route('staff.messages.sent') }}"
                    class="px-6 py-4 text-sm font-medium border-b-2 transition {{ request()->routeIs('staff.messages.sent') ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    Sent
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">To</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Subject</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($messages as $message)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-xs">
                                            {{ substr($message->receiver->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-800">
                                                {{ $message->receiver->name }}
                                            </div>
                                            <div class="text-xs text-gray-400 capitalize">{{ $message->receiver->role }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    {{ $message->subject }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $message->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('staff.messages.show', $message) }}"
                                            class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                            title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('staff.messages.delete', $message) }}"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                    No sent messages.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($messages->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
    </div>
</x-master-layout>