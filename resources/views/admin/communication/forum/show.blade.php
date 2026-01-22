<x-master-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Back Button & Breadcrumb -->
        <div class="mb-6 flex items-center justify-between">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('forum.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <i class="fas fa-comments mr-2"></i>
                            Forum
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-sm font-medium text-gray-500">{{ $forumPost->category->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <a href="{{ route('forum.index') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back to Forum
            </a>
        </div>

        <!-- Post Content -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="p-6 md:p-8">
                <!-- Header -->
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">
                            {{ $forumPost->category->name }}
                        </span>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $forumPost->title }}</h1>
                        <div class="flex items-center text-sm text-gray-500 space-x-4">
                            <span class="flex items-center">
                                <i class="fas fa-user-circle mr-1.5"></i>
                                {{ $forumPost->is_anonymous ? 'Anonymous' : $forumPost->user->name }}
                            </span>
                            <span class="flex items-center">
                                <i class="far fa-clock mr-1.5"></i>
                                {{ $forumPost->created_at->diffForHumans() }}
                            </span>
                            <span class="flex items-center">
                                <i class="far fa-eye mr-1.5"></i>
                                {{ $forumPost->view_count }} views
                            </span>
                        </div>
                    </div>

                    <!-- Like Button -->
                    <form action="{{ route('forum.like', $forumPost->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex flex-col items-center group transition duration-150 ease-in-out {{ $forumPost->likes->where('user_id', auth()->id())->count() > 0 ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}">
                            <i
                                class="{{ $forumPost->likes->where('user_id', auth()->id())->count() > 0 ? 'fas' : 'far' }} fa-heart text-2xl mb-1 group-hover:scale-110 transform transition"></i>
                            <span class="text-sm font-medium">{{ $forumPost->likes->count() }}</span>
                        </button>
                    </form>
                </div>

                @if($forumPost->poll && $forumPost->poll->is_active)
                    <div class="bg-indigo-50 rounded-lg p-6 mb-6 border border-indigo-100">
                        <h3 class="text-lg font-bold text-indigo-900 mb-4 flex items-center">
                            <i class="fas fa-poll mr-2"></i> {{ $forumPost->poll->question }}
                        </h3>

                        @if($forumPost->poll->hasVoted(auth()->id()))
                            <!-- Results View -->
                            <div class="space-y-4">
                                @foreach($forumPost->poll->options as $option)
                                    @php
                                        $totalVotes = $forumPost->poll->votes->count();
                                        $percentage = $totalVotes > 0 ? round(($option->vote_count / $totalVotes) * 100) : 0;
                                    @endphp
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-sm font-medium text-gray-700">{{ $option->option_text }}</span>
                                            <span class="text-sm font-medium text-gray-500">{{ $percentage }}%
                                                ({{ $option->vote_count }} votes)</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                                <p class="text-xs text-gray-500 mt-2 text-right">Total Votes: {{ $totalVotes }}</p>
                            </div>
                        @else
                            <!-- Voting Form -->
                            <form action="{{ route('forum.poll.vote', $forumPost->poll->id) }}" method="POST">
                                @csrf
                                <div class="space-y-3 mb-4">
                                    @foreach($forumPost->poll->options as $option)
                                        <div class="flex items-center">
                                            <input id="option_{{ $option->id }}" name="option_id" type="radio"
                                                value="{{ $option->id }}"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" required>
                                            <label for="option_{{ $option->id }}"
                                                class="ml-3 block text-sm font-medium text-gray-700">
                                                {{ $option->option_text }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-200 text-sm">
                                    Vote
                                </button>
                            </form>
                        @endif
                    </div>
                @endif

                <!-- Body -->
                <div class="prose max-w-none text-gray-800 leading-relaxed mb-6">
                    {!! nl2br(e($forumPost->content)) !!}
                </div>

                @if($forumPost->is_locked)
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-lock text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    This discussion has been locked by moderators. No further comments are allowed.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Comments Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-comment-dots mr-2 text-indigo-500"></i>
                Comments ({{ $forumPost->comments->count() }})
            </h3>

            <!-- Comment List -->
            <div class="space-y-6 mb-8">
                @forelse($forumPost->comments as $comment)
                    <div class="flex space-x-4">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-circle text-3xl text-gray-300"></i>
                        </div>
                        <div class="flex-1 bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="text-sm font-bold text-gray-900">
                                    {{ $comment->is_anonymous ? 'Anonymous' : $comment->user->name }}
                                </h4>
                                <span class="text-xs text-gray-500">
                                    {{ $comment->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <div class="text-gray-700 text-sm">
                                {!! nl2br(e($comment->content)) !!}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="far fa-comments text-4xl mb-3 text-gray-300"></i>
                        <p>No comments yet. Be the first to join the discussion!</p>
                    </div>
                @endforelse
            </div>

            <!-- Add Comment Form -->
            @if(!$forumPost->is_locked)
                <div class="border-t border-gray-100 pt-6">
                    <form action="{{ route('forum.comments.store', $forumPost->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="content" class="sr-only">Add a comment</label>
                            <textarea name="content" id="content" rows="3"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3"
                                placeholder="Share your thoughts..." required></textarea>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_anonymous" id="comment_is_anonymous"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <label for="comment_is_anonymous" class="ml-2 block text-sm text-gray-700">Com.
                                    Anon.</label>
                            </div>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <i class="fas fa-paper-plane mr-2"></i> Post Comment
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-master-layout>