<x-master-layout>
    <div class="fade-in">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Pending Book Requests</h1>
            <p class="text-gray-500 text-sm">Review and approve book requests from staff</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Book
                                Details</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Requested
                                By</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Requested
                                Date</th>
                            <th
                                class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($requests as $request)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-14 bg-gray-50 rounded border border-gray-100 flex items-center justify-center text-gray-300">
                                            @if($request->book->cover_image)
                                                <img src="{{ asset('storage/' . $request->book->cover_image) }}"
                                                    class="w-full h-full object-cover rounded">
                                            @else
                                                <i class="fas fa-book"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-800">{{ $request->book->title }}</div>
                                            <div class="text-xs text-gray-400">{{ $request->book->author }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                            {{ substr($request->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-700">{{ $request->user->name }}</div>
                                            <div class="text-[10px] text-gray-400 uppercase font-bold">
                                                {{ $request->user->role }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $request->created_at->format('M d, Y') }}
                                    <div class="text-xs text-gray-300">{{ $request->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2" x-data="{ showApprove: false }">
                                        <button @click="showApprove = !showApprove"
                                            class="bg-green-50 text-green-700 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-green-600 hover:text-white transition shadow-sm border border-green-100">
                                            Approve
                                        </button>

                                        <form action="{{ route('librarian.requests.cancel', $request->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to cancel this request?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-50 text-red-700 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-600 hover:text-white transition shadow-sm border border-red-100">
                                                Cancel
                                            </button>
                                        </form>

                                        <!-- Simple inline approval form -->
                                        <template x-if="showApprove">
                                            <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
                                                role="dialog" aria-modal="true">
                                                <div
                                                    class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                                        aria-hidden="true" @click="showApprove = false"></div>
                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                                        aria-hidden="true">&#8203;</span>
                                                    <div
                                                        class="inline-block align-middle bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                                                        <form
                                                            action="{{ route('librarian.requests.approve', $request->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="mb-4">
                                                                <h3 class="text-lg font-bold text-gray-900 mb-2">Approve
                                                                    Request</h3>
                                                                <p class="text-sm text-gray-500">Set a due date for
                                                                    <strong>{{ $request->book->title }}</strong> requested
                                                                    by {{ $request->user->name }}.</p>
                                                            </div>
                                                            <div class="mb-6">
                                                                <label
                                                                    class="block text-xs font-bold text-gray-700 uppercase mb-2">Due
                                                                    Date</label>
                                                                <input type="date" name="due_date" required
                                                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                                                    value="{{ date('Y-m-d', strtotime('+14 days')) }}"
                                                                    class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                                            </div>
                                                            <div class="flex justify-end gap-3">
                                                                <button type="button" @click="showApprove = false"
                                                                    class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700">Cancel</button>
                                                                <button type="submit"
                                                                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-indigo-700 transition">Confirm
                                                                    Approval</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic">
                                    No pending book requests at the moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $requests->links() }}
        </div>
    </div>
</x-master-layout>