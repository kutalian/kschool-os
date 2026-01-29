<x-master-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Start New Discussion</h1>
            <a href="{{ route('forum.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('forum.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" id="title"
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
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @if($categories->isEmpty())
                            <p class="text-sm text-red-500 mt-1">No categories found. Please ask admin to create categories
                                first.</p>
                        @endif
                    </div>

                    <div class="col-span-2">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                        <textarea name="content" id="content" rows="6"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required></textarea>
                    </div>

                    <div class="col-span-2 space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <label for="is_anonymous" class="ml-2 block text-sm text-gray-900">Post Anonymously</label>
                        </div>

                        <div x-data="{ hasPoll: false }">
                            <div class="flex items-center mb-4">
                                <input type="checkbox" name="has_poll" id="has_poll" value="1" x-model="hasPoll"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <label for="has_poll" class="ml-2 block text-sm text-gray-900 font-bold">Add a Poll to
                                    this Discussion</label>
                            </div>

                            <div x-show="hasPoll" x-transition
                                class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4">
                                <div>
                                    <label for="poll_question" class="block text-sm font-medium text-gray-700 mb-1">Poll
                                        Question</label>
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
                                                    placeholder="Option text..." :required="hasPoll"
                                                    x-model="options[index]">
                                                <button type="button" @click="options.splice(index, 1)"
                                                    x-show="options.length > 2" class="text-red-500 hover:text-red-700">
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
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Post Discussion
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>