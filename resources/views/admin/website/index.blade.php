<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Website Management') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ url('/') }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="fas fa-external-link-alt mr-2"></i> Live Website
                </a>
                <a href="{{ route('cms.customize') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-magic mr-2"></i> Launch Customizer
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <div
                    class="bg-gradient-to-r from-blue-700 to-blue-900 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden">
                    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between">
                        <div class="mb-6 md:mb-0">
                            <h3 class="text-3xl font-black mb-2">Build Your School Brand</h3>
                            <p class="text-blue-100 max-w-md">The <strong>{{ $activeTheme->name ?? 'Default' }}</strong>
                                theme is active. Use the Master Customizer to manage your site's identity, content, and
                                structure in one place.</p>
                            <div class="mt-6 flex space-x-4">
                                <a href="{{ route('cms.customize') }}"
                                    class="bg-white text-blue-900 px-6 py-2.5 rounded-lg font-bold hover:bg-blue-50 transition shadow-lg">
                                    Start Customizing
                                </a>
                                <a href="{{ route('cms.themes') }}"
                                    class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-blue-500 transition border border-blue-400">
                                    Change Theme
                                </a>
                            </div>
                        </div>
                        <div
                            class="w-full md:w-64 h-40 bg-white/10 rounded-xl backdrop-blur-md border border-white/20 p-4 flex flex-col justify-center items-center text-center">
                            @if($settings->logo_path)
                                <img src="{{ $settings->logo_path }}" class="h-20 object-contain mb-2">
                            @else
                                <i class="fas fa-school text-4xl mb-2"></i>
                            @endif
                            <p class="text-xs font-bold uppercase tracking-widest text-blue-200">
                                {{ $settings->school_name ?? 'School Identity' }}</p>
                        </div>
                    </div>
                    <!-- Subtle background decoration -->
                    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-blue-400/10 rounded-full blur-2xl">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Quick Access Cards -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
                    <div
                        class="w-12 h-12 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition">
                        <i class="fas fa-id-card text-xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Site Identity</h4>
                    <p class="text-sm text-gray-500 mb-4">Manage your school name, contact email, logo, and favicon.</p>
                    <a href="{{ route('cms.customize') }}?panel=identity"
                        class="text-blue-600 text-sm font-bold hover:underline">Manage Identity →</a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
                    <div
                        class="w-12 h-12 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center mb-4 group-hover:bg-purple-600 group-hover:text-white transition">
                        <i class="fas fa-edit text-xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Homepage Content</h4>
                    <p class="text-sm text-gray-500 mb-4">Edit the Hero, About, and Facilities sections of your
                        homepage.</p>
                    <a href="{{ route('cms.customize') }}?panel=content"
                        class="text-blue-600 text-sm font-bold hover:underline">Edit Content →</a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
                    <div
                        class="w-12 h-12 rounded-lg bg-green-100 text-green-600 flex items-center justify-center mb-4 group-hover:bg-green-600 group-hover:text-white transition">
                        <i class="fas fa-copy text-xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Dynamic Pages</h4>
                    <h4 class="font-bold text-gray-800 mb-2">Pages Manager</h4>
                    <p class="text-sm text-gray-500 mb-4">Manage your custom pages like "About Us" or "Contact".</p>
                    <a href="{{ route('admin.cms.pages.index') }}"
                        class="text-blue-600 text-sm font-bold hover:underline">Manage Pages →</a>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-slate-50 border border-slate-100 rounded-lg p-4 text-center">
                    <p class="text-2xl font-black text-slate-800">{{ $stats['pages']['count'] }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Active Pages</p>
                </div>
                <div class="bg-slate-50 border border-slate-100 rounded-lg p-4 text-center">
                    <p class="text-2xl font-black text-slate-800">{{ $stats['content']['sections'] }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Content Sections</p>
                </div>
                <div class="bg-slate-50 border border-slate-100 rounded-lg p-4 text-center">
                    <p class="text-2xl font-black text-slate-800">
                        {{ count(File::directories(resource_path('views/themes'))) }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Available Themes</p>
                </div>
                <div class="bg-slate-50 border border-slate-100 rounded-lg p-4 text-center">
                    <p class="text-2xl font-black text-slate-800">100%</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Mobile Ready</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>