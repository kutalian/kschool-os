<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gallery: ' . $gallery->title) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold mb-2">Upload Photos</h3>
                        <form action="{{ route('gallery.upload', $gallery) }}" method="POST"
                            enctype="multipart/form-data" class="flex gap-4 items-center">
                            @csrf
                            <input type="file" name="photo" class="border rounded p-2" required>
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Upload Photo
                            </button>
                        </form>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach ($gallery->photos as $photo)
                            <div class="relative group">
                                <img src="{{ Storage::url($photo->file_path) }}" alt="Photo"
                                    class="w-full h-40 object-cover rounded">
                                <form action="{{ route('gallery.photo.destroy', $photo) }}" method="POST"
                                    class="absolute top-2 right-2 hidden group-hover:block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white rounded-full p-1 hover:bg-red-700"
                                        onclick="return confirm('Delete photo?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>