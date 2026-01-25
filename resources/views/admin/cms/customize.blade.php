<x-master-layout>
    <div class="flex h-[calc(100vh-64px)] -m-6 overflow-hidden">
        <!-- Sidebar Customizer Panel -->
        <div class="w-80 bg-white border-r border-gray-200 flex flex-col h-full shadow-xl z-20">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                <h2 class="font-bold text-gray-800">Customizer</h2>
                <a href="{{ route('cms.themes') }}" class="text-xs text-gray-500 hover:text-red-500">
                    <i class="fas fa-times"></i> Close
                </a>
            </div>

            <form action="{{ route('cms.customize.save') }}" method="POST" enctype="multipart/form-data"
                class="flex-1 flex flex-col overflow-hidden">
                @csrf
                <div class="flex-1 overflow-y-auto p-4 space-y-6">

                    @foreach($manifest['settings'] ?? [] as $groupKey => $group)
                        <div class="space-y-4">
                            <h3 class="font-semibold text-gray-700 text-sm uppercase tracking-wider border-b border-gray-100 pb-2">
                                {{ $group['label'] ?? ucfirst($groupKey) }}
                            </h3>
                            
                            @foreach($group['fields'] ?? [] as $fieldKey => $field)
                                <div class="space-y-1">
                                    <label class="block text-xs font-medium text-gray-500">{{ $field['label'] ?? ucfirst($fieldKey) }}</label>
                                    
                                    @if($field['type'] === 'text')
                                        <input type="text" name="config[{{ $groupKey }}][{{ $fieldKey }}]"
                                            value="{{ $config[$groupKey][$fieldKey] ?? $field['default'] ?? '' }}"
                                            class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                            
                                    @elseif($field['type'] === 'textarea')
                                        <textarea name="config[{{ $groupKey }}][{{ $fieldKey }}]" rows="3"
                                            class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ $config[$groupKey][$fieldKey] ?? $field['default'] ?? '' }}</textarea>

                                    @elseif($field['type'] === 'color')
                                        <div class="flex items-center gap-2">
                                            <input type="color" name="config[{{ $groupKey }}][{{ $fieldKey }}]"
                                                value="{{ $config[$groupKey][$fieldKey] ?? $field['default'] ?? '#000000' }}"
                                                class="h-8 w-8 rounded cursor-pointer border-gray-300 p-0"
                                                oninput="this.nextElementSibling.value = this.value">
                                            <input type="text" value="{{ $config[$groupKey][$fieldKey] ?? $field['default'] ?? '#000000' }}"
                                                class="text-xs border-gray-300 rounded-md w-20 bg-gray-50" readonly>
                                        </div>

                                    @elseif($field['type'] === 'image')
                                        @if(isset($config[$groupKey][$fieldKey]) && $config[$groupKey][$fieldKey])
                                            <div class="mb-2 p-2 border rounded bg-gray-50 relative group">
                                                <img src="{{ asset($config[$groupKey][$fieldKey]) }}" alt="Preview" class="h-12 mx-auto object-contain">
                                                <input type="hidden" name="config[{{ $groupKey }}][{{ $fieldKey }}]" value="{{ $config[$groupKey][$fieldKey] }}">
                                            </div>
                                        @endif
                                        <input type="file" name="images[{{ $groupKey }}][{{ $fieldKey }}]" accept="image/*"
                                            class="w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">

                                    @elseif($field['type'] === 'checkbox')
                                        <label class="inline-flex items-center cursor-pointer mt-1">
                                            <input type="hidden" name="config[{{ $groupKey }}][{{ $fieldKey }}]" value="0">
                                            <input type="checkbox" name="config[{{ $groupKey }}][{{ $fieldKey }}]" value="1"
                                                {{ ($config[$groupKey][$fieldKey] ?? $field['default'] ?? false) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-xs text-gray-600">Enable</span>
                                        </label>
                                    @endif
                                    
                                    @if(isset($field['help']))
                                        <p class="text-[10px] text-gray-400 italic mt-0.5">{{ $field['help'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <hr class="border-gray-100">

                    <!-- Custom CSS Section (Always available) -->
                    <div class="space-y-2">
                        <h3 class="font-semibold text-gray-700 text-sm uppercase tracking-wider">Custom CSS</h3>
                        <textarea name="config[custom_css]" rows="4"
                            class="w-full text-xs font-mono border-gray-300 rounded-md bg-gray-900 text-green-400 p-3"
                            placeholder=".my-class { color: red; }">{{ $config['custom_css'] ?? '' }}</textarea>
                    </div>

                </div>

                <div class="p-4 border-t border-gray-200 bg-gray-50">
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-save mr-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Preview Area -->
        <div class="flex-1 bg-gray-200 relative flex flex-col">
            <div
                class="bg-white border-b border-gray-300 p-2 flex justify-center items-center gap-4 text-xs text-gray-500 shadow-sm z-10">
                <span><i class="fas fa-desktop"></i> Desktop Preview</span>
                <span class="text-gray-300">|</span>
                <a href="{{ url('/') }}" target="_blank" class="hover:text-blue-600"><i
                        class="fas fa-external-link-alt"></i> Open Live Site</a>
            </div>

            <div class="flex-1 overflow-hidden relative p-4 flex justify-center">
                <iframe src="{{ url('/') }}"
                    class="w-full h-full bg-white shadow-2xl rounded-lg border-none max-w-[1600px]"
                    title="Site Preview"></iframe>
            </div>
        </div>
    </div>
</x-master-layout>