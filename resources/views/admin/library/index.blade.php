<x-master-layout>
    <div class="max-w-6xl mx-auto py-8" x-data="{
        activeTab: '{{ $view }}',
        showAddBook: false,
        showAddCategory: false,
        showIssueBook: false,
        bookToIssue: null,
        searchUser: '',
        usersList: [],
        selectedUser: null,
        
        async searchUsers() {
            if(this.searchUser.length < 2) return;
            let res = await fetch('{{ route('library.users.search') }}?q=' + this.searchUser);
            this.usersList = await res.json();
        },
        selectUser(user) {
            this.selectedUser = user;
            this.searchUser = user.username;
            this.usersList = [];
        },
        
        returnModal: false,
        returnIssueId: null,
        returnBookTitle: '',
        returnUserName: '',
        
        openReturnModal(id, title, user) {
            this.returnIssueId = id;
            this.returnBookTitle = title;
            this.returnUserName = user;
            this.returnModal = true;
        }
    }">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Library Management</h1>
                <p class="text-gray-500 mt-1">Manage books, inventory, and circulation.</p>
            </div>
            <div class="flex gap-3">
                @if($view === 'books')
                    <button @click="showAddBook = true"
                        class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">
                        <i class="fas fa-plus"></i> Add Book
                    </button>
                    <button @click="showAddCategory = true"
                        class="flex items-center gap-2 bg-white border border-gray-300 text-gray-700 px-5 py-2.5 rounded-lg hover:bg-gray-50 transition font-medium shadow-sm">
                        <i class="fas fa-tags"></i> Categories
                    </button>
                    <a href="{{ route('library.history.all') }}"
                        class="flex items-center gap-2 bg-white border border-gray-300 text-gray-700 px-5 py-2.5 rounded-lg hover:bg-gray-50 transition font-medium shadow-sm">
                        <i class="fas fa-history"></i> View History
                    </a>
                @endif
                @if($view === 'categories')
                    <button @click="showAddCategory = true"
                        class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">
                        <i class="fas fa-plus"></i> Add Category
                    </button>
                @endif
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex space-x-1 bg-gray-100 p-1 rounded-xl mb-6 w-fit">
            <a href="?view=books"
                :class="activeTab === 'books' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                class="px-6 py-2.5 rounded-lg font-medium text-sm transition-all duration-200">
                <i class="fas fa-book mr-2"></i> All Books
            </a>
            <a href="?view=issued"
                :class="activeTab === 'issued' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                class="px-6 py-2.5 rounded-lg font-medium text-sm transition-all duration-200">
                <i class="fas fa-hand-holding-open mr-2"></i> Issued Books
            </a>
            <a href="?view=categories"
                :class="activeTab === 'categories' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                class="px-6 py-2.5 rounded-lg font-medium text-sm transition-all duration-200">
                <i class="fas fa-layer-group mr-2"></i> Categories
            </a>
        </div>

        <!-- Content -->
        @if($view === 'books')
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <!-- Books Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="p-4 font-semibold text-gray-600 text-sm">Title / Author</th>
                                <th class="p-4 font-semibold text-gray-600 text-sm">Category</th>
                                <th class="p-4 font-semibold text-gray-600 text-sm text-center">Availability</th>
                                <th class="p-4 font-semibold text-gray-600 text-sm text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($books as $book)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4">
                                        <div class="flex items-center gap-4">
                                            @if($book->cover_image)
                                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover" class="w-12 h-16 object-cover rounded shadow-sm">
                                            @else
                                                <div class="w-12 h-16 bg-gray-100 rounded flex items-center justify-center text-gray-400">
                                                    <i class="fas fa-book text-xl"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-bold text-gray-800">{{ $book->title }}</div>
                                                <div class="text-sm text-gray-500">{{ $book->author }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <span
                                            class="bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-full text-xs font-semibold">
                                            {{ $book->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex flex-col items-center">
                                            <span class="font-bold text-gray-800">{{ $book->available_copies }} /
                                                {{ $book->quantity }}</span>
                                            @if($book->available_copies > 0)
                                                <span class="text-xs text-green-600 font-medium">Available</span>
                                            @else
                                                <span class="text-xs text-red-500 font-medium">Out of Stock</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4 text-right">
                                        @if($book->available_copies > 0)
                                            <a href="{{ route('library.issue.create', $book->id) }}"
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium mr-3">
                                                <i class="fas fa-share-square mr-1"></i> Issue
                                            </a>
                                        @endif
                                        <a href="{{ route('library.history', $book->id) }}"
                                            class="text-gray-400 hover:text-blue-600 text-sm mr-2" title="View History">
                                            <i class="fas fa-history"></i>
                                        </a>
                                        <a href="{{ route('library.book.edit', $book->id) }}"
                                            class="text-gray-400 hover:text-green-600 text-sm mr-2" title="Edit Book">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('library.book.delete_confirm', $book->id) }}"
                                            class="text-gray-400 hover:text-red-600 text-sm" title="Delete Book">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-gray-500">No books found. Add one to get
                                        started.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($view === 'issued')
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="p-4 font-semibold text-gray-600 text-sm">Book</th>
                            <th class="p-4 font-semibold text-gray-600 text-sm">Issued To</th>
                            <th class="p-4 font-semibold text-gray-600 text-sm">Dates</th>
                            <th class="p-4 font-semibold text-gray-600 text-sm text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($issues as $issue)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4">
                                    <div class="font-bold text-gray-800">{{ $issue->book->title }}</div>
                                </td>
                                <td class="p-4">
                                    @if($issue->user)
                                        <div class="font-bold text-gray-800">{{ $issue->user->username }}</div>
                                        <div class="text-xs text-gray-500 capitalize">{{ $issue->user->role }}</div>
                                    @else
                                        <span class="text-red-500">User Deleted</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="text-sm">
                                        <span class="text-gray-500">Issued:</span> {{ $issue->issue_date->format('M d') }}
                                    </div>
                                    <div
                                        class="text-sm font-medium {{ $issue->is_overdue ? 'text-red-600' : 'text-green-600' }}">
                                        <span class="text-gray-500 font-normal">Due:</span>
                                        {{ $issue->due_date->format('M d') }}
                                        @if($issue->is_overdue) (Overdue) @endif
                                    </div>
                                </td>
                                <td class="p-4 text-right">
                                    <button
                                        @click="openReturnModal('{{ $issue->id }}', '{{ $issue->book->title }}', '{{ $issue->user->username ?? 'Unknown' }}')"
                                        class="bg-white border border-gray-200 text-indigo-600 hover:bg-indigo-50 px-3 py-1.5 rounded-lg text-sm font-medium transition shadow-sm mr-2">
                                        Return
                                    </button>
                                    <a href="{{ route('library.history', $issue->book->id) }}"
                                        class="text-gray-400 hover:text-blue-600 text-sm inline-block align-middle"
                                        title="View History">
                                        <i class="fas fa-history"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-500">No books currently issued.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @elseif($view === 'categories')
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="p-4 font-semibold text-gray-600 text-sm">Name</th>
                            <th class="p-4 font-semibold text-gray-600 text-sm">Books Count</th>
                            <th class="p-4 font-semibold text-gray-600 text-sm text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="p-4 font-bold text-gray-800">{{ $category->name }}</td>
                                <td class="p-4 text-gray-600">{{ $category->books_count }} books</td>
                                <td class="p-4 text-right">...</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-8 text-center text-gray-500">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Add Book Modal -->
        <div x-show="showAddBook" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm"
            style="display: none;">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 border border-gray-100 overflow-hidden"
                @click.away="showAddBook = false">
                <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Add New Book</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Enter book details to add to inventory.</p>
                    </div>
                    <button @click="showAddBook = false"
                        class="text-gray-400 hover:text-gray-600 transition p-2 hover:bg-gray-100 rounded-full"><i
                            class="fas fa-times"></i></button>
                </div>
                <form action="{{ route('library.book.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Book Title</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i
                                        class="fas fa-heading"></i></span>
                                <input type="text" name="title" required
                                    class="w-full pl-10 rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm placeholder-gray-300"
                                    placeholder="e.g. The Great Gatsby">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Author</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i
                                        class="fas fa-user-pen"></i></span>
                                <input type="text" name="author" required
                                    class="w-full pl-10 rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm placeholder-gray-300"
                                    placeholder="e.g. F. Scott Fitzgerald">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Cover Image (Optional)</label>
                            <input type="file" name="cover_image" accept="image/*"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 rounded-xl border border-gray-200 transition shadow-sm">
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Category</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i
                                            class="fas fa-tag"></i></span>
                                    <select name="category_id" required
                                        class="w-full pl-10 rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm bg-white cursor-pointer">
                                        @if(isset($categories))
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Quantity</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i
                                            class="fas fa-cubes"></i></span>
                                    <input type="number" name="quantity" min="1" value="1" required
                                        class="w-full pl-10 rounded-xl border-gray-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm text-center">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white py-3 rounded-xl font-bold shadow-lg shadow-blue-500/30 transition-all transform hover:scale-[1.02]">
                        <i class="fas fa-plus mr-2"></i> Add Book
                    </button>
                </form>
            </div>
        </div>

        <!-- Add Category Modal -->
        <div x-show="showAddCategory" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm"
            style="display: none;">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-4 overflow-hidden"
                @click.away="showAddCategory = false">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-800">Add Category</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('library.category.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Category Name</label>
                            <input type="text" name="name" required
                                class="w-full rounded-xl border-gray-200 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm placeholder-gray-300">
                        </div>
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-2.5 rounded-xl hover:bg-blue-700 font-medium shadow-md transition">Save
                            Category</button>
                    </form>
                </div>
            </div>
        </div>



        <!-- Return Book Modal -->
        <!-- Return Book Modal -->
        <div x-show="returnModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm"
            style="display: none;">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-4 overflow-hidden" style="max-width: 24rem;"
                @click.away="returnModal = false">
                <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-base font-bold text-gray-800">Return Book</h3>
                </div>
                <div class="p-5">
                    <form action="{{ route('library.return') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="issue_id" :value="returnIssueId">

                        <div class="bg-blue-50 p-3 rounded-lg border border-blue-100 mb-2 text-sm">
                            <div class="flex flex-col gap-1">
                                <p class="text-blue-900 font-medium truncate"><span
                                        class="text-blue-500 w-10 inline-block">Book:</span> <span
                                        x-text="returnBookTitle"></span></p>
                                <p class="text-blue-900 font-medium truncate"><span
                                        class="text-blue-500 w-10 inline-block">User:</span> <span
                                        x-text="returnUserName"></span></p>
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">Return
                                Condition</label>
                            <input type="text" name="return_condition"
                                class="w-full rounded-lg border-gray-200 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm placeholder-gray-300 text-sm py-2"
                                placeholder="e.g. Good, Damaged...">
                        </div>

                        <div class="flex gap-2 pt-2">
                            <button type="button" @click="returnModal = false"
                                class="flex-1 bg-white border border-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-50 font-medium transition shadow-sm text-sm">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 font-medium shadow-md transition text-sm"
                                style="background-color: #4f46e5; color: white;">
                                Confirm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-master-layout>