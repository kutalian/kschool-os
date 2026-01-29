<x-master-layout>
    <div class="flex items-center justify-center min-h-[80vh]">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 max-w-lg w-full text-center">

            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-yellow-100 mb-6">
                <svg class="h-10 w-10 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">Delete Comment?</h2>
            <p class="text-gray-500 mb-6">Are you sure you want to delete this comment?</p>

            <div class="bg-gray-50 rounded-lg p-4 mb-8 text-left border border-gray-100">
                <div class="flex items-start">
                    <div
                        class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mr-3 mt-1 shrink-0">
                        <i class="fas fa-comment"></i>
                    </div>
                    <div>
                        <div class="text-gray-700 text-sm italic mb-2">
                            "{!! nl2br(e(Str::limit($comment->content, 150))) !!}"
                        </div>
                        <p class="text-xs text-gray-500">
                            By {{ $comment->is_anonymous ? 'Anonymous' : $comment->user->name }} |
                            {{ $comment->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex space-x-4">
                <a href="{{ route('forum.show', $comment->post->id) }}"
                    class="w-1/2 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Cancel
                </a>
                <form action="{{ route('forum.comments.destroy', $comment->id) }}" method="POST" class="w-1/2">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-trash-alt mr-2"></i> Confirm Delete
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-master-layout>