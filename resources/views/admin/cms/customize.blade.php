<x-master-layout>
    <div x-data="{ 
        currentPanel: 'main', 
        activeSectionId: null,
        activePageId: null,
        init() {
            // Check for initial panel in URL if needed
        }
    }" class="flex h-[calc(100vh-64px)] -m-6 overflow-hidden">
        
        <!-- Sidebar Customizer Panel -->
        <div class="w-80 bg-white border-r border-gray-200 flex flex-col h-full shadow-xl z-20">
            
            <!-- Global Header -->
            <div class="p-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                <div class="flex items-center">
                    <button x-show="currentPanel !== 'main'" @click="currentPanel = 'main'" class="mr-2 text-gray-400 hover:text-blue-600">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <h2 class="font-bold text-gray-800" x-text="currentPanel === 'main' ? 'Customizer' : currentPanel.charAt(0).toUpperCase() + currentPanel.slice(1).replace('-', ' ')"></h2>
                </div>
                <a href="{{ route('admin.website.index') }}" class="text-xs text-gray-500 hover:text-red-500">
                    <i class="fas fa-times"></i> Close
                </a>
            </div>

            <form action="{{ route('cms.customize.save') }}" method="POST" enctype="multipart/form-data"
                class="flex-1 flex flex-col overflow-hidden">
                @csrf
                
                <div class="flex-1 overflow-y-auto">
                    
                    <!-- MASTER MENU -->
                    <div x-show="currentPanel === 'main'" class="p-4 space-y-2">
                        <button type="button" @click="currentPanel = 'identity'" class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-blue-50 text-gray-700 transition group border border-transparent hover:border-blue-100">
                            <span class="flex items-center font-medium"><i class="fas fa-id-card w-6 text-blue-500"></i> Site Identity</span>
                            <i class="fas fa-chevron-right text-[10px] text-gray-300 group-hover:text-blue-400"></i>
                        </button>
                        
                        <button type="button" @click="currentPanel = 'content'" class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-orange-50 text-gray-700 transition group border border-transparent hover:border-orange-100">
                            <span class="flex items-center font-medium"><i class="fas fa-edit w-6 text-orange-500"></i> Theme Content</span>
                            <i class="fas fa-chevron-right text-[10px] text-gray-300 group-hover:text-orange-400"></i>
                        </button>

                        <button type="button" @click="currentPanel = 'pages'" class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-green-50 text-gray-700 transition group border border-transparent hover:border-green-100">
                            <span class="flex items-center font-medium"><i class="fas fa-copy w-6 text-green-500"></i> Dynamic Pages</span>
                            <i class="fas fa-chevron-right text-[10px] text-gray-300 group-hover:text-green-400"></i>
                        </button>

                        <button type="button" @click="currentPanel = 'settings'" class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-purple-50 text-gray-700 transition group border border-transparent hover:border-purple-100">
                            <span class="flex items-center font-medium"><i class="fas fa-paint-roller w-6 text-purple-500"></i> Theme Layout</span>
                            <i class="fas fa-chevron-right text-[10px] text-gray-300 group-hover:text-purple-400"></i>
                        </button>
                    </div>

                    <!-- IDENTITY PANEL -->
                    <div x-show="currentPanel === 'identity'" class="p-4 space-y-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">School Name</label>
                                <input type="text" name="identity[school_name]" value="{{ $settings->school_name }}" placeholder="e.g. Divine Gift Model School" class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Site Tagline</label>
                                <input type="text" name="identity[tagline]" value="{{ $settings->tagline }}" placeholder="e.g. Excellence in Education" class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Contact Email</label>
                                <input type="email" name="identity[school_email]" value="{{ $settings->school_email }}" class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <!-- Theme Specific Identity Extras -->
                            @if(isset($manifest['settings']['identity']['fields']))
                                @foreach($manifest['settings']['identity']['fields'] as $fieldKey => $field)
                                    @php 
                                        $isReserved = in_array($fieldKey, ['site_title', 'school_name', 'tagline', 'logo_url', 'logo_path']);
                                    @endphp
                                    @if(!$isReserved)
                                        <div class="space-y-1">
                                            <label class="block text-xs font-medium text-gray-500">{{ $field['label'] ?? ucfirst($fieldKey) }}</label>
                                            <input type="text" name="config[identity][{{ $fieldKey }}]"
                                                value="{{ $config['identity'][$fieldKey] ?? $field['default'] ?? '' }}"
                                                class="w-full text-sm border-gray-300 rounded focus:border-blue-500 focus:ring-0">
                                            @if(isset($field['help']))
                                                <p class="text-[10px] text-gray-400 italic">{{ $field['help'] }}</p>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Brand Logo</label>
                                @if($settings->logo_path)
                                    <div class="mb-2 p-2 border rounded bg-gray-50">
                                        <img src="{{ $settings->logo_path }}" class="h-12 mx-auto object-contain">
                                    </div>
                                @endif
                                <input type="file" name="identity_logo" class="w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Favicon</label>
                                @if($settings->favicon_path)
                                    <div class="mb-2 w-8 h-8 mx-auto border rounded bg-gray-50 p-1">
                                        <img src="{{ $settings->favicon_path }}" class="w-full h-full object-contain">
                                    </div>
                                @endif
                                <input type="file" name="identity_favicon" class="w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700">
                            </div>
                        </div>
                    </div>

                    <!-- CONTENT PANEL -->
                    <div x-show="currentPanel === 'content'" class="p-4 space-y-4">
                        <p class="text-xs text-gray-500 italic mb-4">Edit sections supported by the {{ $activeTheme->name }} theme.</p>
                        @foreach($sections as $section)
                            <div class="border rounded-lg overflow-hidden border-gray-100 shadow-sm">
                                <button type="button" @click="activeSectionId = (activeSectionId === {{ $section->id }} ? null : {{ $section->id }})" class="w-full flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 transition">
                                    <span class="text-sm font-bold text-gray-700">{{ $section->title ?? 'Unnamed Section' }}</span>
                                    <i class="fas text-[10px] text-gray-400" :class="activeSectionId === {{ $section->id }} ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                </button>
                                <div x-show="activeSectionId === {{ $section->id }}" class="p-4 space-y-4 bg-white border-t border-gray-100">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-tighter mb-1">Display Title</label>
                                        <input type="text" name="sections[{{ $section->id }}][title]" value="{{ $section->title }}" class="w-full text-sm border-gray-200 rounded">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-tighter mb-1">Body Content</label>
                                        <textarea name="sections[{{ $section->id }}][content]" rows="3" class="w-full text-sm border-gray-200 rounded">{{ $section->content }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-tighter mb-1">Section Media</label>
                                        @if($section->image_path)
                                            <img src="{{ $section->image_path }}" class="h-16 w-full object-cover rounded mb-2">
                                        @endif
                                        <input type="file" name="section_images[{{ $section->id }}]" class="w-full text-xs text-gray-400">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- PAGES PANEL -->
                    <div x-show="currentPanel === 'pages'" class="p-4 space-y-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-gray-500 uppercase">Site Pages</span>
                            <a href="{{ route('admin.cms.pages.create') }}" class="text-[10px] bg-green-100 text-green-700 px-2 py-1 rounded-full font-bold hover:bg-green-200">
                                <i class="fas fa-plus"></i> NEW
                            </a>
                        </div>
                        <div class="space-y-2">
                            @foreach($pages as $page)
                                <div class="flex items-center justify-between p-2 rounded border border-gray-50 bg-white hover:border-blue-100 group transition">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $page->title }}</p>
                                        <p class="text-[10px] text-gray-400">/p/{{ $page->slug }}</p>
                                    </div>
                                    <a href="{{ route('admin.cms.pages.edit', $page) }}" class="text-gray-300 group-hover:text-blue-500">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- THEME SETTINGS PANEL -->
                    <div x-show="currentPanel === 'settings'" class="p-4 space-y-8">
                        @foreach($manifest['settings'] ?? [] as $groupKey => $group)
                            @continue($groupKey === 'identity') {{-- Handled in Identity Panel --}}
                            <div class="space-y-4">
                                <h3 class="font-bold text-gray-800 text-xs uppercase tracking-widest border-b border-gray-100 pb-2 flex items-center">
                                    {{ $group['label'] ?? ucfirst($groupKey) }}
                                </h3>
                                
                                @foreach($group['fields'] ?? [] as $fieldKey => $field)
                                    <div class="space-y-1">
                                        <label class="block text-xs font-medium text-gray-500">{{ $field['label'] ?? ucfirst($fieldKey) }}</label>
                                        
                                        @if($field['type'] === 'text')
                                            <input type="text" name="config[{{ $groupKey }}][{{ $fieldKey }}]"
                                                value="{{ $config[$groupKey][$fieldKey] ?? $field['default'] ?? '' }}"
                                                class="w-full text-sm border-gray-300 rounded focus:border-blue-500 focus:ring-0">
                                                
                                        @elseif($field['type'] === 'textarea')
                                            <textarea name="config[{{ $groupKey }}][{{ $fieldKey }}]" rows="3"
                                                class="w-full text-sm border-gray-300 rounded focus:border-blue-500 focus:ring-0">{{ $config[$groupKey][$fieldKey] ?? $field['default'] ?? '' }}</textarea>

                                        @elseif($field['type'] === 'color')
                                            <div class="flex items-center gap-2">
                                                <input type="color" name="config[{{ $groupKey }}][{{ $fieldKey }}]"
                                                    value="{{ $config[$groupKey][$fieldKey] ?? $field['default'] ?? '#000000' }}"
                                                    class="h-8 w-8 rounded cursor-pointer border-gray-300 p-0"
                                                    oninput="this.nextElementSibling.value = this.value">
                                                <input type="text" value="{{ $config[$groupKey][$fieldKey] ?? $field['default'] ?? '#000000' }}"
                                                    class="text-xs border-gray-300 rounded w-20 bg-gray-50" readonly>
                                            </div>

                                        @elseif($field['type'] === 'image')
                                            @if(isset($config[$groupKey][$fieldKey]) && $config[$groupKey][$fieldKey])
                                                <div class="mb-2 p-2 border rounded bg-gray-50 text-center">
                                                    <img src="{{ asset($config[$groupKey][$fieldKey]) }}" class="h-12 mx-auto object-contain mb-1">
                                                    <input type="hidden" name="config[{{ $groupKey }}][{{ $fieldKey }}]" value="{{ $config[$groupKey][$fieldKey] }}">
                                                </div>
                                            @endif
                                            <input type="file" name="images[{{ $groupKey }}][{{ $fieldKey }}]" accept="image/*"
                                                class="w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded file:bg-blue-50 file:text-blue-700">

                                        @elseif($field['type'] === 'checkbox')
                                            <label class="inline-flex items-center cursor-pointer mt-1">
                                                <input type="hidden" name="config[{{ $groupKey }}][{{ $fieldKey }}]" value="0">
                                                <input type="checkbox" name="config[{{ $groupKey }}][{{ $fieldKey }}]" value="1"
                                                    {{ ($config[$groupKey][$fieldKey] ?? $field['default'] ?? false) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                <span class="ml-2 text-xs text-gray-600">Enable</span>
                                            </label>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        <!-- Custom CSS (Inside Theme Settings or Page Settings) -->
                        <div class="space-y-4 pt-4">
                            <h3 class="font-bold text-gray-800 text-xs uppercase tracking-widest border-b border-gray-100 pb-2">Advanced Styles</h3>
                            <textarea name="config[custom_css]" rows="4"
                                class="w-full text-xs font-mono border-gray-800 rounded bg-gray-900 text-green-400 p-3"
                                placeholder=".my-class { color: red; }">{{ $config['custom_css'] ?? '' }}</textarea>
                        </div>
                    </div>

                </div>

                <div class="p-4 border-t border-gray-200 bg-gray-50">
                    <button type="submit"
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 transition">
                        <i class="fas fa-magic mr-2"></i> Save & Publish
                    </button>
                </div>
            </form>
        </div>

        <!-- Preview Area -->
        <div class="flex-1 bg-gray-100 relative flex flex-col">
            <div class="bg-white border-b border-gray-200 p-2.5 flex justify-center items-center gap-6 text-[10px] font-bold text-gray-400 uppercase tracking-widest shadow-sm z-10">
                <span class="flex items-center text-blue-500"><i class="fas fa-desktop mr-2"></i> Responsive Preview</span>
                <span class="text-gray-200 font-thin">|</span>
                <a href="{{ url('/') }}" target="_blank" class="hover:text-blue-600 flex items-center transition"><i class="fas fa-external-link-alt mr-2"></i> Open Live Site</a>
            </div>

            <div class="flex-1 overflow-hidden relative p-6 flex justify-center bg-slate-100">
                <div class="w-full h-full bg-white shadow-2xl rounded-xl overflow-hidden border border-gray-200 max-w-[1400px]">
                    <iframe src="{{ url('/') }}" class="w-full h-full border-none" title="Site Preview"></iframe>
                </div>
            </div>
        </div>
    </div>
</x-master-layout>