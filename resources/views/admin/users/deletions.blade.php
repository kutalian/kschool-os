<x-master-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-black text-gray-900">Deletion Requests</h1>
            <p class="text-gray-500 font-medium mt-1">Review and action account deletion requests from users.</p>
        </div>

        @if(session('success'))
            <div
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6 flex items-center gap-3">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6 flex items-center gap-3">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div
            class="bg-white rounded-[2rem] border border-gray-100 shadow-[0_20px_50px_rgb(0,0,0,0.03)] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest">User</th>
                            <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest">Role</th>
                            <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest">Requested
                                At</th>
                            <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest">Reason</th>
                            <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($requests as $request)
                            <tr class="hover:bg-gray-50/30 transition-all">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-sm">
                                            {{ strtoupper(substr($request->name ?? $request->username, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-black text-gray-900">
                                                {{ $request->name ?? $request->username }}</div>
                                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                                {{ $request->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span
                                        class="px-3 py-1 bg-gray-100 text-gray-600 text-[10px] font-black rounded-lg uppercase tracking-widest border border-gray-200">
                                        {{ $request->role }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm font-medium text-gray-600">
                                        {{ $request->deletion_requested_at->format('M d, Y') }}</div>
                                    <div class="text-[10px] font-bold text-gray-400">
                                        {{ $request->deletion_requested_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm text-gray-500 italic max-w-xs truncate"
                                        title="{{ $request->deletion_reason }}">
                                        {{ $request->deletion_reason ?? 'No reason provided' }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <form action="{{ route('admin.users.deletions.reject', $request) }}" method="POST"
                                            onsubmit="return confirm('Restore this user account?')">
                                            @csrf
                                            <button type="submit"
                                                class="text-indigo-600 hover:text-indigo-900 font-black text-[10px] uppercase tracking-widest">
                                                Restore
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.deletions.approve', $request) }}" method="POST"
                                            onsubmit="return confirm('Permanently delete this account? This action cannot be undone.')">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-50 text-red-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all border border-red-100">
                                                Delete Permanent
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div
                                        class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-200">
                                        <i class="fas fa-user-check text-4xl"></i>
                                    </div>
                                    <h5 class="text-lg font-black text-gray-900">All Clear!</h5>
                                    <p class="text-gray-500 font-medium mt-1">There are no pending account deletion
                                        requests.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($requests->hasPages())
                <div class="px-8 py-6 border-t border-gray-50">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>
</x-master-layout>