<x-master-layout>
    <div class="mb-6">
        <a href="{{ route('admin.cms.pages.index') }}"
            class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1 mb-2">
            <i class="fas fa-arrow-left"></i> Back to Pages
        </a>
        <h1 class="text-2xl font-bold text-gray-800">{{ $isEdit ? 'Edit Page' : 'Create New Page' }}</h1>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r" role="alert">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
        <form action="{{ $isEdit ? route('admin.cms.pages.update', $page) : route('admin.cms.pages.store') }}"
            method="POST">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Page Title</label>
                        <input type="text" name="title" value="{{ old('title', $page->title) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Slug (URL)</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span
                                class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-gray-500 sm:text-sm">/p/</span>
                            <input type="text" name="slug" value="{{ old('slug', $page->slug) }}"
                                class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="automatic-if-empty">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Content (HTML/Markdown
                            Supported)</label>
                        <textarea name="content" rows="20"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono">{{ old('content', $page->content) }}</textarea>
                    </div>
                </div>

                <!-- Sidebar Settings -->
                <div class="space-y-6">
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <h3 class="font-bold text-gray-800 text-sm uppercase">Publishing</h3>

                        <div class="flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $page->is_active ?? true) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">Page is Active</label>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Template</label>
                            <select name="template"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="default" {{ old('template', $page->template) == 'default' ? 'selected' : '' }}>Default Template</option>
                                <option value="full-width" {{ old('template', $page->template) == 'full-width' ? 'selected' : '' }}>Full Width</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ $isEdit ? 'Update Page' : 'Save Page' }}
                        </button>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <h3 class="font-bold text-gray-800 text-sm uppercase">SEO Settings</h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Meta Description</label>
                            <textarea name="meta_description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('meta_description', $page->meta_description) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Meta Keywords</label>
                            <input type="text" name="meta_keywords"
                                value="{{ old('meta_keywords', $page->meta_keywords) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-master-layout>