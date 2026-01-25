<x-master-layout>
    <div class="fade-in">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Book Inventory</h1>
            <a href="{{ route('librarian.books.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i> Add New Book
            </a>
        </div>

        {{-- Search & Filter --}}
        <div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <form action="{{ route('librarian.books.index') }}" method="GET" class="flex gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by title, author, or ISBN..."
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <button type="submit"
                    class="bg-gray-800 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">Search</button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Book Info
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">
                                Copies</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">
                                Available</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($books as $book)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($book->cover_image)
                                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover"
                                                class="h-12 w-8 object-cover rounded shadow-sm mr-4">
                                        @else
                                            <div
                                                class="h-12 w-8 bg-gray-200 rounded flex items-center justify-center mr-4 text-gray-400">
                                                <i class="fas fa-book"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-gray-900">{{ $book->title }}</div>
                                            <div class="text-xs text-gray-500">{{ $book->author }}</div>
                                            <div class="text-xs text-gray-400">ISBN: {{ $book->isbn ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs font-medium">
                                        {{ $book->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-700 text-center">
                                    {{ $book->quantity }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm font-bold text-center {{ $book->available_copies > 0 ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $book->available_copies }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('librarian.books.edit', $book->id) }}"
                                        class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('librarian.books.destroy', $book->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Are you sure you want to delete this book?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <div class="mb-4">
                                        <i class="fas fa-book-open text-4xl text-gray-300"></i>
                                    </div>
                                    <p class="text-lg font-medium">No books found</p>
                                    <p class="text-sm">Try adjusting your search or add a new book.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100">
                {{ $books->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-master-layout>