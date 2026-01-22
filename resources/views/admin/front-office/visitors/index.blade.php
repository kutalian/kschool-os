<x-master-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Visitor Book</h1>
            <p class="text-gray-500 text-sm">Manage front office visitor records</p>
        </div>
        <a href="{{ route('visitors.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Visitor
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <div class="text-gray-500 text-xs uppercase font-semibold">Today's Visitors</div>
            <div class="text-2xl font-bold text-gray-800 mt-1">
                {{ \App\Models\Visitor::whereDate('check_in', today())->count() }}</div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm uppercase">
                        <th class="p-4 font-semibold border-b">Visitor Name</th>
                        <th class="p-4 font-semibold border-b">Purpose</th>
                        <th class="p-4 font-semibold border-b">Meeting With</th>
                        <th class="p-4 font-semibold border-b">Check In</th>
                        <th class="p-4 font-semibold border-b">Check Out</th>
                        <th class="p-4 font-semibold border-b text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($visitors as $visitor)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4">
                                <div class="font-medium text-gray-800">{{ $visitor->name }}</div>
                                <div class="text-xs text-gray-500">{{ $visitor->phone }}</div>
                            </td>
                            <td class="p-4 text-gray-600">{{ $visitor->purpose }}</td>
                            <td class="p-4">
                                <span
                                    class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-medium">{{ $visitor->person_to_meet ?? 'N/A' }}</span>
                            </td>
                            <td class="p-4 text-gray-600 text-sm">
                                {{ $visitor->check_in->format('d M, h:i A') }}
                            </td>
                            <td class="p-4 text-gray-600 text-sm">
                                @if($visitor->check_out)
                                    {{ $visitor->check_out->format('h:i A') }}
                                @else
                                    <span class="text-yellow-600 bg-yellow-50 px-2 py-1 rounded text-xs">In Campus</span>
                                @endif
                            </td>
                            <td class="p-4 text-right flex justify-end gap-2">
                                <a href="{{ route('visitors.edit', $visitor) }}"
                                    class="text-blue-600 hover:bg-blue-50 p-2 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </a>
                                <form action="{{ route('visitors.destroy', $visitor) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:bg-red-50 p-2 rounded-lg transition"
                                        title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 mb-2 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    No visitors recorded yet.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $visitors->links() }}
        </div>
    </div>
</x-master-layout>