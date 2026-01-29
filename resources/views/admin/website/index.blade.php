<x-master-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Website Manager</h1>
                <p class="text-gray-500 mt-1">Manage your school's online presence, themes, and content.</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ url('/') }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl font-bold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                    <i class="fas fa-external-link-alt mr-2 text-blue-500"></i> Live Website
                </a>
                <a href="{{ route('cms.customize') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 shadow-lg shadow-blue-200 transition">
                    <i class="fas fa-magic mr-2"></i> Launch Customizer
                </a>
            </div>
        </div>

        <div class="mb-12">
            <div
                class="bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 rounded-3xl p-10 text-white shadow-2xl relative overflow-hidden group">
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex-1">
                        <span
                            class="inline-block px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-4 border border-white/10">Brand
                            Identity</span>
                        <h3 class="text-4xl font-black mb-4 leading-tight">Build Your School Brand</h3>
                        <p class="text-blue-100 text-lg max-w-xl mb-8 leading-relaxed">
                            The <strong class="text-white">{{ $activeTheme->name ?? 'Default' }}</strong> theme is
                            active.
                            Use the Master Customizer to manage your site's identity, content, and structure in one
                            place.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('cms.customize') }}"
                                class="bg-white text-blue-900 px-8 py-3.5 rounded-2xl font-black hover:bg-blue-50 transition shadow-xl transform group-hover:scale-105 duration-300">
                                Start Customizing
                            </a>
                            <a href="{{ route('cms.themes') }}"
                                class="bg-blue-600/50 backdrop-blur-md text-white px-8 py-3.5 rounded-2xl font-black hover:bg-blue-600 transition border border-white/20">
                                Change Theme
                            </a>
                        </div>
                    </div>
                    <div
                        class="w-full md:w-72 aspect-square bg-white/5 rounded-[2.5rem] backdrop-blur-xl border border-white/10 p-8 flex flex-col justify-center items-center text-center shadow-inner group-hover:border-white/20 transition duration-500">
                        @if($settings->logo_path)
                            <img src="{{ $settings->logo_path }}" class="h-24 object-contain mb-4 filter drop-shadow-lg">
                        @else
                            <i class="fas fa-school text-5xl mb-4 opacity-50"></i>
                        @endif
                        <p class="text-xs font-black uppercase tracking-widest text-blue-200">
                            {{ $settings->school_name ?? 'School Identity' }}
                        </p>
                    </div>
                </div>
                <!-- Rich background decoration -->
                <div
                    class="absolute top-0 right-0 -mt-24 -mr-24 w-96 h-96 bg-blue-400/20 rounded-full blur-[100px] animate-pulse">
                </div>
                <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-64 h-64 bg-indigo-400/20 rounded-full blur-[80px]">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- Quick Access Cards -->
            <div
                class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 hover:shadow-xl hover:translate-y-[-4px] transition-all duration-300 group">
                <div
                    class="w-14 h-14 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center mb-6 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-id-card text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-3">Site Identity</h4>
                <p class="text-gray-500 mb-6 leading-relaxed">Manage your school name, contact email, logo, and favicon.
                </p>
                <a href="{{ route('settings.edit') }}"
                    class="inline-flex items-center text-blue-600 font-bold hover:gap-2 transition-all">
                    Manage Identity <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>
            </div>

            <div
                class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 hover:shadow-xl hover:translate-y-[-4px] transition-all duration-300 group">
                <div
                    class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center mb-6 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-edit text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-3">Homepage Content</h4>
                <p class="text-gray-500 mb-6 leading-relaxed">Edit the Hero, About, and Facilities sections of your
                    homepage.</p>
                <a href="{{ route('cms.customize') }}?panel=content"
                    class="inline-flex items-center text-blue-600 font-bold hover:gap-2 transition-all">
                    Edit Content <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>
            </div>

            <div
                class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 hover:shadow-xl hover:translate-y-[-4px] transition-all duration-300 group">
                <div
                    class="w-14 h-14 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center mb-6 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-copy text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-3">Pages Manager</h4>
                <p class="text-gray-500 mb-6 leading-relaxed">Manage your custom pages like "About Us" or "Contact".</p>
                <a href="{{ route('admin.cms.pages.index') }}"
                    class="inline-flex items-center text-blue-600 font-bold hover:gap-2 transition-all">
                    Manage Pages <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>
            </div>
        </div>

        <!-- Stats Bar -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <p class="text-2xl font-black text-gray-800 leading-none">{{ $stats['pages']['count'] }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Active Pages</p>
                </div>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <p class="text-2xl font-black text-gray-800 leading-none">{{ $stats['content']['sections'] }}</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Sections</p>
                </div>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <i class="fas fa-palette"></i>
                </div>
                <div>
                    <p class="text-2xl font-black text-gray-800 leading-none">
                        {{ count(File::directories(resource_path('views/themes'))) }}
                    </p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Themes</p>
                </div>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div>
                    <p class="text-2xl font-black text-gray-800 leading-none">100%</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Responsive</p>
                </div>
            </div>
        </div>
    </div>
</x-master-layout>