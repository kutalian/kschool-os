<x-master-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Announcements</h1>
            <a href="{{ route('announcements.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-bullhorn mr-2"></i> Post Announcement
            </a>
        </div>

        <div class="space-y-4">
            @foreach($announcements as $announcement)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition duration-200 border-l-4 border-l-blue-500">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $announcement->title }}</h3>
                            <div class="text-xs text-gray-500 mt-1">
                                <span><i class="fas fa-user mr-1"></i> Posted by
                                    {{ $announcement->creator->name ?? 'Admin' }}</span>
                                <span class="mx-2">•</span>
                                <span><i class="far fa-clock mr-1"></i>
                                    {{ $announcement->created_at->format('M d, Y h:i A') }}</span>
                                <span class="mx-2">•</span>
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">To:
                                    {{ ucfirst($announcement->target_audience) }}</span>
                            </div>
                        </div>
                        <span
                            class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $announcement->announcement_type }}</span>
                    </div>

                    <div class="prose max-w-none text-gray-700 mt-3 whitespace-pre-wrap">
                        {{ $announcement->content }}
                    </div>

                    <div class="flex justify-end mt-4 pt-4 border-t border-gray-100 space-x-3">
                        <button class="text-gray-400 hover:text-gray-600 cursor-not-allowed" title="Not implemented yet"><i
                                class="fas fa-edit mr-1"></i> Edit</button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $announcements->links() }}
        </div>
    </div>
</x-master-layout>