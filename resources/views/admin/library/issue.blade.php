<x-master-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8" x-data="{
        searchUser: '',
        usersList: [],
        selectedUser: null,
        loading: false,

        async searchUsers() {
            if(this.searchUser.length < 2) {
                this.usersList = [];
                return;
            }
            this.loading = true;
            try {
                let res = await fetch('{{ route('library.users.search') }}?q=' + this.searchUser);
                this.usersList = await res.json();
            } catch (e) {
                console.error(e);
                this.usersList = [];
            } finally {
                this.loading = false;
            }
        },
        selectUser(user) {
            this.selectedUser = user;
            this.searchUser = user.username;
            this.usersList = [];
        }
    }">
        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Back Link -->
            <a href="{{ route('library.index') }}"
                class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back to Library
            </a>

            <!-- Alerts -->
            @if (session('success'))
                <div class="rounded-xl bg-green-50 p-4 border border-green-200 flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-xl bg-red-50 p-4 border border-red-200 flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-xl bg-red-50 p-4 border border-red-200">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                        <h3 class="text-red-800 font-bold">There were some problems with your input:</h3>
                    </div>
                    <ul class="list-disc list-inside text-red-700 text-sm ml-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Book Details Card -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                <!-- Visual Header -->
                <div class="h-48 bg-slate-900 relative flex items-center justify-center overflow-hidden"
                    style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); min-height: 12rem;">
                    <i class="fas fa-book text-6xl text-white/50 z-10 relative"></i>
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full blur-3xl -ml-12 -mb-12 pointer-events-none">
                    </div>
                </div>

                <!-- Info Body -->
                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-1">{{ $book->title }}</h1>
                            <p class="text-gray-500 text-lg">{{ $book->author }}</p>
                        </div>
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm font-semibold">
                            {{ $book->category->name ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="space-y-4 border-t border-gray-100 pt-6">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-bold text-gray-600">ISBN</span>
                            <span class="font-mono text-gray-800">{{ $book->isbn ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-bold text-gray-600">Availability</span>
                            <span
                                class="flex items-center gap-2 font-bold {{ $book->available_copies > 0 ? 'text-green-600' : 'text-red-600' }}">
                                <span
                                    class="w-2 h-2 rounded-full {{ $book->available_copies > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ $book->available_copies }} of {{ $book->quantity }} Available
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Issue Form Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-1">Issue Book</h2>
                    <p class="text-gray-500 text-sm">Complete the details below to assign this book to a member</p>
                </div>

                <form action="{{ route('library.issue') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">

                    <!-- Issue To -->
                    <div class="space-y-2 relative" @click.away="usersList = []">
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide">Issue To</label>

                        <!-- Input -->
                        <div class="relative group" x-show="!selectedUser">
                            <span
                                class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 pointer-events-none group-focus-within:text-blue-600 transition-colors z-10 h-full">
                                <i class="fas fa-search"></i>
                            </span>
                            <!-- Added inline style padding-left to force spacing -->
                            <input type="text" x-model="searchUser" @input.debounce.300ms="searchUsers()"
                                placeholder="Search student or staff name..."
                                class="w-full pl-12 pr-4 py-3 rounded-lg border-gray-200 bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-sm placeholder-gray-400"
                                style="padding-left: 3rem !important;" autocomplete="off">
                        </div>
                        <input type="hidden" name="user_id" :value="selectedUser?.id">

                        <!-- Dropdown -->
                        <div x-show="searchUser.length >= 2 && !selectedUser" style="display: none;"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="absolute left-0 right-0 top-full mt-1 bg-white border border-gray-100 rounded-lg shadow-xl z-50 max-h-[300px] overflow-y-auto ring-1 ring-black ring-opacity-5">

                            <!-- Loading -->
                            <div x-show="loading" class="p-4 text-center text-gray-500 text-sm">
                                <i class="fas fa-circle-notch fa-spin text-blue-500 mr-2"></i> Searching...
                            </div>
                            <!-- No Results -->
                            <div x-show="!loading && usersList.length === 0"
                                class="p-4 text-center text-gray-500 text-sm">
                                No users found.
                            </div>

                            <template x-for="user in usersList" :key="user.id">
                                <div @click="selectUser(user)"
                                    class="p-3 hover:bg-blue-50 cursor-pointer transition flex items-center gap-3 group border-b border-gray-50 last:border-0">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800 text-sm group-hover:text-blue-700"
                                            x-text="user.username"></div>
                                        <div class="text-xs text-gray-500 capitalize" x-text="user.role"></div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Selected User Display -->
                        <div x-show="selectedUser" style="display: none;"
                            class="p-3 bg-blue-50 border border-blue-100 rounded-lg flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center shadow-sm">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 text-sm" x-text="selectedUser.username"></div>
                                    <div class="text-xs text-blue-600 capitalize" x-text="selectedUser.role"></div>
                                </div>
                            </div>
                            <button type="button" @click="selectedUser = null; searchUser = ''; usersList = []"
                                class="text-gray-400 hover:text-red-500 p-2 transition">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Return Date -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide">Return Date</label>
                        <div class="relative group">
                            <span
                                class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 pointer-events-none group-focus-within:text-blue-600 transition-colors z-10 h-full">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                            <input type="date" name="due_date" required min="{{ date('Y-m-d') }}"
                                class="w-full pl-12 pr-4 py-3 rounded-lg border-gray-200 bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all text-sm cursor-pointer text-gray-700"
                                style="padding-left: 3rem !important;">
                        </div>
                    </div>

                    <!-- Button with bigger size and indigo color -->
                    <button type="submit" :disabled="!selectedUser"
                        class="w-full py-5 rounded-xl text-white font-bold text-xl transition-all duration-200 flex items-center justify-center gap-3 mt-6 shadow-xl hover:shadow-2xl hover:-translate-y-1"
                        style="background-color: #4f46e5; color: white;"
                        :style="!selectedUser ? 'background-color: #a5b4fc; cursor: not-allowed; opacity: 0.8;' : 'background-color: #4f46e5;'">
                        Confirm Issue <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('library.history', $book->id) }}"
                    class="inline-flex items-center gap-2 text-gray-600 hover:text-blue-600 font-medium transition-colors bg-white px-4 py-2 rounded-lg border border-gray-200 hover:border-blue-200 shadow-sm">
                    <i class="fas fa-history"></i> View Full History
                </a>
            </div>
        </div>
    </div>
</x-master-layout>