<x-master-layout>
    <div class="fade-in max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('librarian.books.index') }}"
                class="text-gray-500 hover:text-blue-600 transition mb-2 inline-block">
                <i class="fas fa-arrow-left mr-1"></i> Back to Inventory
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Add New Book</h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('librarian.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Book Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Author <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="author" value="{{ old('author') }}" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        @error('author') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
                        <input type="text" name="isbn" value="{{ old('isbn') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        @error('isbn') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category <span
                                class="text-red-500">*</span></label>
                        <select name="category_id" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Copies <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Publisher</label>
                        <input type="text" name="publisher" value="{{ old('publisher') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Shelf Location</label>
                        <input type="text" name="shelf_location" value="{{ old('shelf_location') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
                        <input type="file" name="cover_image" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, max 2MB.</p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('librarian.books.index') }}"
                        class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition">Cancel</a>
                    <button type="submit"
                        class="px-6 py-2 rounded-lg bg-blue-600 text-white font-bold hover:bg-blue-700 transition shadow-sm">Save
                        Book</button>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>