<x-master-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Hostel Management</h1>
        <a href="{{ route('hostel.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i> Add New Hostel
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            @if($hostels->isEmpty())
                <div class="text-center py-10 text-gray-500">
                    <i class="fas fa-building text-4xl mb-3 opacity-50"></i>
                    <p>No hostels found. Click "Add New Hostel" to create one.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Hostel Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Warden</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Rooms</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($hostels as $hostel)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <a href="{{ route('hostel.show', $hostel->id) }}" class="hover:text-blue-600">
                                                            {{ $hostel->name }}
                                                        </a>
                                                    </div>
                                                    <div class="text-xs text-gray-500">{{ $hostel->address }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                {{ $hostel->type === 'Boys' ? 'bg-blue-100 text-blue-800' :
                                ($hostel->type === 'Girls' ? 'bg-pink-100 text-pink-800' : 'bg-gray-100 text-gray-800') }}">
                                                        {{ $hostel->type }} Hostel
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $hostel->warden_name ?? 'N/A' }}</div>
                                                    <div class="text-xs text-gray-500">{{ $hostel->warden_contact }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $hostel->rooms_count }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('hostel.show', $hostel->id) }}"
                                                        class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('hostel.edit', $hostel->id) }}"
                                                        class="text-yellow-600 hover:text-yellow-900 mr-3">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('hostel.destroy', $hostel->id) }}" method="POST"
                                                        class="inline-block"
                                                        onsubmit="return confirm('Are you sure you want to delete this hostel?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $hostels->links() }}
                </div>
            @endif
        </div>
    </div>
</x-master-layout>