<x-master-layout>
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $hostel->name }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $hostel->type === 'Boys' ? 'bg-blue-100 text-blue-800' : ($hostel->type === 'Girls' ? 'bg-pink-100 text-pink-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ $hostel->type }} Hostel
                    </span>
                    <span class="mx-2">•</span>
                    <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i> {{ $hostel->address ?? 'No Address' }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('hostel.index') }}"
                    class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition">
                    &larr; Back
                </a>
                <a href="{{ route('hostel.edit', $hostel->id) }}"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r" role="alert">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Hostel Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Warden Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Warden Details</h3>
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl font-bold">
                            {{ substr($hostel->warden_name ?? 'N', 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $hostel->warden_name ?? 'Not Assigned' }}</p>
                            <p class="text-sm text-gray-500">Hostel Warden</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone w-6 text-center text-gray-400"></i>
                            <span>{{ $hostel->warden_contact ?? 'No Contact' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Statistics</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-3 rounded-lg text-center">
                            <span class="block text-2xl font-bold text-blue-700">{{ $hostel->rooms->count() }}</span>
                            <span class="text-xs text-blue-600 font-medium uppercase">Rooms</span>
                        </div>
                        <div class="bg-green-50 p-3 rounded-lg text-center">
                            <span class="block text-2xl font-bold text-green-700">
                                {{ $hostel->rooms->sum('capacity') }}
                            </span>
                            <span class="text-xs text-green-600 font-medium uppercase">Capacity</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500">
                            {{ $hostel->description ?? 'No description provided.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Rooms List -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col h-full">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">Rooms</h3>
                        <button onclick="document.getElementById('addRoomModal').classList.remove('hidden')"
                            class="text-sm bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700 transition">
                            <i class="fas fa-plus mr-1"></i> Add Room
                        </button>
                    </div>

                    <div class="overflow-x-auto flex-1">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Room No</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Capacity</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cost/Term</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($hostel->rooms as $room)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            {{ $room->room_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $room->room_type }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs font-bold">
                                                {{ $room->allocations_count ?? 0 }} / {{ $room->capacity }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">
                                            ${{ number_format($room->cost_per_term, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('hostel.rooms.destroy', $room->id) }}" method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('Delete Room {{ $room->room_number }}?');">
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
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                            No rooms added yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Room Modal -->
    <div id="addRoomModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Add New Room</h3>
                    <button onclick="document.getElementById('addRoomModal').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('hostel.rooms.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="hostel_id" value="{{ $hostel->id }}">

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Room Number</label>
                            <input type="text" name="room_number" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="room_type" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="Single">Single</option>
                                <option value="Double">Double</option>
                                <option value="Triple">Triple</option>
                                <option value="Dormitory">Dormitory</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Capacity</label>
                            <input type="number" name="capacity" min="1" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cost per Term</label>
                            <input type="number" name="cost_per_term" min="0" step="0.01" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="2"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                        </div>
                    </div>

                    <div class="mt-5 sm:mt-6">
                        <button type="submit"
                            class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                            Add Room
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-master-layout>