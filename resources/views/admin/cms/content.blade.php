<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Homepage Content') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6">
                @foreach ($sections as $section)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" x-data="{ editing: false }">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-bold text-gray-800 capitalize">{{ $section->section_key }}
                                        Section</h3>
                                    @if(isset($manifest['sections'][$section->section_key]))
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i> Supported by {{ $activeTheme->name }}
                                        </span>
                                        <span
                                            class="text-xs text-gray-400 italic">({{ $manifest['sections'][$section->section_key]['label'] ?? '' }})</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                            <i class="fas fa-info-circle mr-1"></i> Not used by current theme
                                        </span>
                                    @endif
                                </div>
                                <button @click="editing = !editing"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <span x-show="!editing">Edit</span>
                                    <span x-show="editing">Cancel</span>
                                </button>
                            </div>

                            <!-- Display Mode -->
                            <div x-show="!editing" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="col-span-2 space-y-2">
                                    <p><span class="font-semibold">Title:</span> {{ $section->title ?? '-' }}</p>
                                    <p><span class="font-semibold">Subtitle:</span> {{ $section->subtitle ?? '-' }}</p>
                                    <p><span class="font-semibold">Content:</span> <span
                                            class="text-gray-600">{{ Str::limit($section->content, 100) }}</span></p>
                                </div>
                                <div>
                                    @if($section->image_path)
                                        <img src="{{ $section->image_path }}" alt="Section Image"
                                            class="w-full h-32 object-cover rounded">
                                    @endif
                                    @if(!empty($section->settings))
                                        <div class="mt-2 text-xs text-gray-500 bg-gray-50 p-2 rounded">
                                            <span class="font-semibold">Settings:</span>
                                            <pre>{{ json_encode($section->settings, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Edit Form -->
                            <div x-show="editing" style="display: none;">
                                <form action="{{ route('cms.content.update', $section) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <x-input-label :value="__('Title')" />
                                            <x-text-input type="text" name="title" :value="$section->title"
                                                class="block mt-1 w-full" />
                                        </div>
                                        <div>
                                            <x-input-label :value="__('Subtitle')" />
                                            <x-text-input type="text" name="subtitle" :value="$section->subtitle"
                                                class="block mt-1 w-full" />
                                        </div>
                                        <div class="md:col-span-2">
                                            <x-input-label :value="__('Content')" />
                                            <textarea name="content" rows="3"
                                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ $section->content }}</textarea>
                                        </div>
                                        <div>
                                            <x-input-label :value="__('Image')" />
                                            <input type="file" name="image"
                                                class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                        </div>
                                        <div>
                                            <x-input-label :value="__('Action Button (Text)')" />
                                            <x-text-input type="text" name="action_text" :value="$section->action_text"
                                                class="block mt-1 w-full" placeholder="e.g. Learn More" />
                                        </div>
                                        <!-- Advanced Settings (JSON) -->
                                        <div class="md:col-span-2">
                                            <x-input-label :value="__('Advanced Settings (JSON)')" />
                                            @foreach($section->settings ?? [] as $key => $value)
                                                <div class="flex gap-2 mt-1">
                                                    <span
                                                        class="inline-flex items-center px-3 rounded border border-gray-300 bg-gray-50 text-gray-500 text-sm">{{ $key }}</span>
                                                    <x-text-input type="text" name="settings[{{ $key }}]" :value="$value"
                                                        class="block w-full" />
                                                </div>
                                            @endforeach
                                            <p class="text-xs text-gray-500 mt-1">These settings are defined by the active
                                                theme.</p>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex justify-end">
                                        <x-primary-button>{{ __('Update Section') }}</x-primary-button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>