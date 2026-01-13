<x-master-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Transport Route</h1>

        <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
            <form action="{{ route('transport.routes.update', $transportRoute->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Route Title</label>
                    <input type="text" name="route_name" value="{{ old('title', $transportRoute->route_name) }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Start Point</label>
                        <input type="text" name="start_point"
                            value="{{ old('start_point', $transportRoute->start_point) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">End Point</label>
                        <input type="text" name="end_point" value="{{ old('end_point', $transportRoute->end_point) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Fare ($)</label>
                        <input type="number" step="0.01" name="fare" value="{{ old('fare', $transportRoute->fare) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Assign Vehicle</label>
                        <select name="vehicle_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Vehicle (Optional)</option>
                            @foreach($vehicles as $v)
                                <option value="{{ $v->id }}" {{ $transportRoute->vehicle_id == $v->id ? 'selected' : '' }}>
                                    {{ $v->vehicle_number }} ({{ $v->driver_name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('transport.index') }}"
                        class="text-gray-600 hover:text-gray-800 font-medium mr-4">Cancel</a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition">Update
                        Route</button>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>