<x-master-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Community Forum</h1>
            <a href="{{ route('forum.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                New Discussion
            </a>
        </div>

        <div class="space-y-4">
            @foreach($posts as $post)
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-2">
                                <a href="{{ route('forum.show', $post->id) }}" class="hover:text-blue-600 transition">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($post->content, 150) }}</p>
                            <div class="flex items-center text-sm text-gray-500 space-x-4">
                                <span><i class="fas fa-user-circle mr-1"></i>
                                    {{ $post->is_anonymous ? 'Anonymous' : ($post->user->name ?? 'User') }}</span>
                                <span><i class="far fa-clock mr-1"></i> {{ $post->created_at->diffForHumans() }}</span>
                                <span><i class="far fa-eye mr-1"></i> {{ $post->view_count }} views</span>
                            </div>
                        </div>
                        <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                            {{ $post->category->name ?? 'General' }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
</x-master-layout>