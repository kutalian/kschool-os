<x-master-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Discussion</h1>
            <a href="{{ route('forum.show', $forum->id) }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('forum.update', $forum->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" id="title"
                            value="{{ old('title', $forum->title) }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>

                    <div class="col-span-2">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category_id" id="category_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $forum->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                        <textarea name="content" id="content" rows="6"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>{{ old('content', $forum->content) }}</textarea>
                    </div>

                    <div class="col-span-2 space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1"
                                {{ old('is_anonymous', $forum->is_anonymous) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <label for="is_anonymous" class="ml-2 block text-sm text-gray-900">Post Anonymously</label>
                        </div>

                        @if($forum->poll)
                            <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-200 space-y-4">
                                <h3 class="text-sm font-bold text-indigo-900 flex items-center">
                                    <i class="fas fa-poll mr-2"></i> poll Details
                                </h3>
                                <div>
                                    <label for="poll_question" class="block text-sm font-medium text-gray-700 mb-1">Poll Question</label>
                                    <input type="text" name="poll_question" id="poll_question"
                                        value="{{ old('poll_question', $forum->poll->question) }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Options (Fixed once created)</label>
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach($forum->poll->options as $option)
                                            <li class="text-sm text-gray-600">{{ $option->option_text }} ({{ $option->vote_count }} votes)</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @else
                            <div x-data="{ hasPoll: false }">
                                <div class="flex items-center mb-4">
                                    <input type="checkbox" name="has_poll" id="has_poll" value="1" x-model="hasPoll"
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <label for="has_poll" class="ml-2 block text-sm text-gray-900 font-bold">Add a Poll to this Discussion</label>
                                </div>

                                <div x-show="hasPoll" x-transition class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4">
                                    <div>
                                        <label for="poll_question" class="block text-sm font-medium text-gray-700 mb-1">Poll Question</label>
                                        <input type="text" name="poll_question" id="poll_question"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            :required="hasPoll">
                                    </div>

                                    <div x-data="{ options: ['', ''] }">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Poll Options</label>
                                        <div class="space-y-2">
                                            <template x-for="(option, index) in options" :key="index">
                                                <div class="flex items-center space-x-2">
                                                    <input type="text" name="poll_options[]"
                                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                        placeholder="Option text..."
                                                        :required="hasPoll"
                                                        x-model="options[index]">
                                                    <button type="button" @click="options.splice(index, 1)" x-show="options.length > 2"
                                                        class="text-red-500 hover:text-red-700">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                        <button type="button" @click="options.push('')"
                                            class="mt-2 text-sm text-blue-600 hover:text-blue-800 font-medium">
                                            <i class="fas fa-plus mr-1"></i> Add Option
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Update Discussion
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>
