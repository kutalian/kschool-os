<x-master-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Vehicle</h1>

        <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
            <form action="{{ route('transport.vehicles.update', $vehicle->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Vehicle Number</label>
                        <input type="text" name="vehicle_number"
                            value="{{ old('vehicle_number', $vehicle->vehicle_number) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Capacity</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $vehicle->capacity) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Driver Name</label>
                    <input type="text" name="driver_name" value="{{ old('driver_name', $vehicle->driver_name) }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Driver License</label>
                        <input type="text" name="driver_license"
                            value="{{ old('driver_license', $vehicle->driver_license) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Driver Phone</label>
                        <input type="text" name="driver_phone" value="{{ old('driver_phone', $vehicle->driver_phone) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select name="status"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="active" {{ $vehicle->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="maintenance" {{ $vehicle->status === 'maintenance' ? 'selected' : '' }}>Maintenance
                        </option>
                        <option value="retired" {{ $vehicle->status === 'retired' ? 'selected' : '' }}>Retired</option>
                    </select>
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('transport.index') }}"
                        class="text-gray-600 hover:text-gray-800 font-medium mr-4">Cancel</a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition">Update
                        Vehicle</button>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>