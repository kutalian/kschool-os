<x-master-layout>
    <div class="fade-in max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('librarian.books.index') }}"
                class="text-gray-500 hover:text-blue-600 transition mb-2 inline-block">
                <i class="fas fa-arrow-left mr-1"></i> Back to Inventory
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Edit Book: {{ $book->title }}</h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('librarian.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Book Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $book->title) }}" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Author <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="author" value="{{ old('author', $book->author) }}" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
                        <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category <span
                                class="text-red-500">*</span></label>
                        <select name="category_id" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Copies <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="quantity" value="{{ old('quantity', $book->quantity) }}" min="1"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Currently Available: {{ $book->available_copies }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Publisher</label>
                        <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Shelf Location</label>
                        <input type="text" name="shelf_location"
                            value="{{ old('shelf_location', $book->shelf_location) }}"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="col-span-2">
                        @if($book->cover_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Current Cover"
                                    class="h-20 w-auto rounded border border-gray-200">
                                <p class="text-xs text-gray-500">Current Cover</p>
                            </div>
                        @endif
                        <label class="block text-sm font-medium text-gray-700 mb-1">Change Cover Image</label>
                        <input type="file" name="cover_image" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('librarian.books.index') }}"
                        class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition">Cancel</a>
                    <button type="submit"
                        class="px-6 py-2 rounded-lg bg-blue-600 text-white font-bold hover:bg-blue-700 transition shadow-sm">Update
                        Book</button>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>