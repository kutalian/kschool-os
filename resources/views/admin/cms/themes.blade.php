<x-master-layout>
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Theme Manager</h1>

        {{-- Help & Instructions Toggle --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                <i class="fas fa-question-circle"></i> Help & Instructions
            </button>
            <div x-show="open" @click.away="open = false"
                class="absolute right-0 mt-2 w-96 bg-white border border-gray-200 rounded-lg shadow-xl p-4 z-50 text-sm text-gray-600"
                style="display: none;">
                <h4 class="font-bold text-gray-800 mb-2">How to manage themes</h4>
                <ul class="list-disc pl-4 space-y-1">
                    <li><strong>Upload:</strong> Upload a `.zip` file containing your theme. The folder name inside the
                        zip will be the theme ID.</li>
                    <li><strong>Activate:</strong> Click 'Activate' to make a theme live. Only one theme can be active
                        at a time.</li>
                    <li><strong>Customize:</strong> Click 'Customize' on the active theme to change colors, logos, and
                        fonts in real-time.</li>
                </ul>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Upload Area -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Upload New Theme</h3>
                <p class="text-sm text-gray-500 mt-1">Upload a .zip file containing the theme structure.</p>
            </div>
            <form action="{{ route('cms.themes.upload') }}" method="POST" enctype="multipart/form-data"
                class="flex items-center gap-3 w-full md:w-auto">
                @csrf
                <input type="file" name="theme_zip" accept=".zip"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition"
                    required>
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium shadow-sm whitespace-nowrap">
                    Upload
                </button>
            </form>
        </div>
    </div>

    <!-- Installed Themes -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($themes as $theme)
            <div
                class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition duration-300 overflow-hidden border border-gray-100 flex flex-col h-full relative">

                {{-- Active Badge --}}
                @if($theme->is_active)
                    <div class="absolute top-4 right-4 z-10">
                        <span
                            class="bg-green-500/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1.5">
                            <i class="fas fa-check-circle"></i> Active
                        </span>
                    </div>
                @endif

                {{-- Screenshot / Placeholder --}}
                <div
                    class="h-48 bg-gray-100 relative overflow-hidden group-hover:opacity-95 transition border-b border-gray-50">
                    @if($theme->screenshot)
                        <img src="{{ asset($theme->screenshot) }}" alt="{{ $theme->name }}" class="w-full h-full object-cover">
                    @else
                        <div
                            class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white">
                            <div class="text-center">
                                <i class="fas fa-palette text-4xl mb-3 opacity-80"></i>
                                <h3 class="font-bold text-xl opacity-90 tracking-wide">{{ $theme->name }}</h3>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="p-6 flex-1 flex flex-col">
                    <div class="mb-4">
                        <div class="flex justify-between items-baseline">
                            <h4 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition">
                                {{ $theme->name }}
                            </h4>
                            <span
                                class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full font-mono">v{{ $theme->version }}</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">
                            By <span class="font-semibold">{{ $theme->manifest['author'] ?? 'Unknown' }}</span>
                        </p>
                        <p class="text-sm text-gray-500 mt-2 line-clamp-2">
                            {{ $theme->manifest['description'] ?? 'A modern theme for your school management system.' }}
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-auto pt-4 border-t border-gray-50">
                        @if(!$theme->is_active)
                            <form action="{{ route('cms.themes.activate', $theme) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-200 rounded-lg font-medium text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 hover:border-blue-200 transition duration-200">
                                    Activate Theme
                                </button>
                            </form>

                            {{-- Delete Button --}}
                            <form action="{{ route('cms.themes.destroy', $theme) }}" method="POST" class="w-full mt-3"
                                onsubmit="return confirm('Are you sure you want to delete this theme? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-white border border-red-100 rounded-lg font-medium text-sm text-red-600 hover:bg-red-50 hover:border-red-200 transition duration-200">
                                    <i class="fas fa-trash-alt mr-2 text-xs"></i> Delete
                                </button>
                            </form>
                        @else
                            <div class="grid grid-cols-2 gap-2">
                                <button disabled
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-50 border border-green-100 rounded-lg font-medium text-sm text-green-700 cursor-default">
                                    <i class="fas fa-check mr-2"></i> Active
                                </button>
                                <a href="{{ route('cms.customize') }}"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-blue-600 rounded-lg font-medium text-sm text-white hover:bg-blue-700 transition">
                                    <i class="fas fa-paint-brush mr-2"></i> Customize
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-master-layout>