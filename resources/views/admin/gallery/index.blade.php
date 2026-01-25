<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Photo Gallery') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-bold">Albums</h3>
                        <a href="{{ route('gallery.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create New Album
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($albums as $album)
                            <div class="border rounded-lg overflow-hidden shadow-lg">
                                <a href="{{ route('gallery.show', $album) }}">
                                    @if($album->cover_image)
                                        <img src="{{ Storage::url($album->cover_image) }}" alt="{{ $album->title }}"
                                            class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-400">No Cover</span>
                                        </div>
                                    @endif
                                </a>
                                <div class="p-4">
                                    <h4 class="font-bold text-lg mb-2">{{ $album->title }}</h4>
                                    <p class="text-gray-600 text-sm mb-2">{{ $album->photos_count }} Photos</p>
                                    <div class="flex justify-between items-center">
                                        <a href="{{ route('gallery.show', $album) }}"
                                            class="text-blue-500 hover:text-blue-700 text-sm">View</a>
                                        <form action="{{ route('gallery.destroy', $album) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm"
                                                onclick="return confirm('Delete this album and all photos?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $albums->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>