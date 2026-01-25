<x-master-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Notice Board</h1>
            <a href="{{ route('notices.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-bullhorn mr-2"></i> Post Notice
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-sm"
                role="alert">
                <strong class="font-bold"><i class="fas fa-check-circle mr-1"></i> Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="space-y-4">
            @forelse($notices as $notice)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition duration-200 {{ $notice->priority == 'Urgent' ? 'border-l-4 border-l-red-500' : ($notice->priority == 'High' ? 'border-l-4 border-l-orange-500' : 'border-l-4 border-l-blue-500') }}">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $notice->title }}</h3>
                            <div class="text-xs text-gray-500 mt-1">
                                <span><i class="fas fa-user mr-1"></i> Posted by
                                    {{ $notice->creator->name ?? 'Admin' }}</span>
                                <span class="mx-2">•</span>
                                <span><i class="far fa-clock mr-1"></i>
                                    {{ $notice->created_at->format('M d, Y h:i A') }}</span>
                                <span class="mx-2">•</span>
                                <span
                                    class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $notice->audience == 'all' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">To:
                                    {{ ucfirst($notice->audience) }}</span>
                            </div>
                        </div>
                        @if($notice->priority == 'Urgent')
                            <span
                                class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 animate-pulse">URGENT</span>
                        @elseif($notice->priority == 'High')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">High
                                Priority</span>
                        @endif
                    </div>

                    <div class="prose max-w-none text-gray-700 mt-3 whitespace-pre-wrap">
                        {{ $notice->message }}
                    </div>

                    <div class="flex justify-end mt-4 pt-4 border-t border-gray-100 space-x-3">
                        <a href="{{ route('notices.edit', $notice->id) }}"
                            class="text-yellow-600 hover:text-yellow-900 transition font-medium text-sm"><i
                                class="fas fa-edit mr-1"></i> Edit</a>
                        <form action="{{ route('notices.destroy', $notice->id) }}" method="POST" class="inline-block"
                            onsubmit="return confirm('Delete this notice?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 transition font-medium text-sm"><i
                                    class="fas fa-trash mr-1"></i> Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-clipboard-list text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Notices Found</h3>
                    <p class="text-gray-500 mb-6">There are no notices posted yet.</p>
                    <a href="{{ route('notices.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-plus mr-2"></i> Create First Notice
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $notices->links() }}
        </div>
    </div>
</x-master-layout>