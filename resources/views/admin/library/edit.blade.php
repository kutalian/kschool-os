<x-master-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto space-y-6">
            <!-- Header -->
            <div class="flex items-center gap-4">
                <a href="{{ route('library.index') }}"
                    class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:text-blue-600 hover:border-blue-200 transition shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Edit Book</h1>
                    <p class="text-gray-500 text-sm">Update details for "{{ $book->title }}"</p>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('library.book.update', $book->id) }}" method="POST" enctype="multipart/form-data"
                    class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <!-- Cover Image Section -->
                        <div class="flex items-start gap-6">
                            <div
                                class="w-32 h-44 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Current Cover"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <i class="fas fa-image text-3xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Update Cover
                                    Image</label>
                                <input type="file" name="cover_image" accept="image/*"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 rounded-xl border border-gray-200 transition shadow-sm mb-2">
                                <p class="text-xs text-gray-500">Supported formats: JPG, PNG. Max size: 2MB.</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Book Title</label>
                            <input type="text" name="title" value="{{ old('title', $book->title) }}" required
                                class="w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm placeholder-gray-300">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Author</label>
                            <input type="text" name="author" value="{{ old('author', $book->author) }}" required
                                class="w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm placeholder-gray-300">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Category</label>
                                <select name="category_id" required
                                    class="w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm bg-white cursor-pointer">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $cat->id == $book->category_id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Total Quantity</label>
                                <input type="number" name="quantity" min="1"
                                    value="{{ old('quantity', $book->quantity) }}" required
                                    class="w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm">
                                <p class="text-xs text-gray-500 mt-1">Currently Available: {{ $book->available_copies }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Shelf Location</label>
                                <input type="text" name="shelf_location"
                                    value="{{ old('shelf_location', $book->shelf_location) }}"
                                    class="w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm placeholder-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">ISBN</label>
                                <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}"
                                    class="w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm placeholder-gray-300">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex items-center gap-3">
                        <a href="{{ route('library.index') }}"
                            class="flex-1 bg-white border border-gray-200 text-gray-700 py-3 rounded-xl hover:bg-gray-50 font-medium transition shadow-sm text-center">
                            Cancel
                        </a>
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 font-medium shadow-md transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-master-layout>