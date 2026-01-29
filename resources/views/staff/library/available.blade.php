<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <a href="{{ route('staff.library.index') }}"
                    class="text-indigo-600 hover:text-indigo-700 transition mb-2 inline-flex items-center text-sm font-medium">
                    <i class="fas fa-arrow-left mr-1"></i> Back to My History
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Available Books</h1>
                <p class="text-gray-500 text-sm">Browse and request books from the school library</p>
            </div>

            <form action="{{ route('staff.library.available') }}" method="GET" class="flex gap-2">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by title, author..."
                        class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full md:w-64 transition shadow-sm text-sm">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
                <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition shadow-sm text-sm">
                    Search
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @forelse($books as $book)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group flex flex-col h-full">
                    <div class="relative aspect-[3/4] bg-gray-50 overflow-hidden">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                <i class="fas fa-book text-5xl mb-3"></i>
                                <span class="text-xs font-medium uppercase tracking-widest">No Cover</span>
                            </div>
                        @endif
                        <div class="absolute top-3 right-3">
                            <span
                                class="bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg text-[10px] font-bold text-indigo-600 uppercase shadow-sm border border-indigo-50">
                                {{ $book->category->name }}
                            </span>
                        </div>
                    </div>

                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-800 line-clamp-2 mb-1 group-hover:text-indigo-600 transition">
                            {{ $book->title }}</h3>
                        <p class="text-xs text-gray-500 mb-4 italic">by {{ $book->author }}</p>

                        <div class="mt-auto space-y-3">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-400">Available:</span>
                                <span
                                    class="font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full border border-green-100">
                                    {{ $book->available_copies }} copies
                                </span>
                            </div>

                            <form action="{{ route('staff.library.request', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-indigo-50 text-indigo-700 border border-indigo-100 py-2 rounded-lg text-xs font-bold hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition shadow-sm">
                                    Request for Pickup
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-white rounded-xl border border-dashed border-gray-200">
                    <i class="fas fa-book-open text-4xl text-gray-200 mb-3"></i>
                    <p class="text-gray-500 font-medium">No books found matching your criteria.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $books->links() }}
        </div>
    </div>
</x-master-layout>