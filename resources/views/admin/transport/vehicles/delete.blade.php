<x-master-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden md:max-w-md">
            <div class="md:flex">
                <div class="w-full p-4">
                    <div class="text-center mb-6">
                        <i class="fas fa-exclamation-triangle text-amber-500 text-5xl mb-4"></i>
                        <h1 class="block text-gray-700 font-bold text-xl mb-2">Delete Vehicle?</h1>
                        <p class="text-gray-600">Are you sure you want to delete vehicle
                            <strong>{{ $vehicle->vehicle_number }}</strong>?</p>
                        <p class="text-sm text-gray-500 mt-2">Driver: {{ $vehicle->driver_name }}</p>
                    </div>

                    <form action="{{ route('transport.vehicles.destroy', $vehicle->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="flex justify-center space-x-4">
                            <a href="{{ route('transport.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                                Cancel
                            </a>
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <i class="fas fa-trash mr-2"></i> Confirm Delete
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-master-layout>