<x-master-layout>
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Hostel: {{ $hostel->name }}</h1>
            <a href="{{ route('hostel.index') }}" class="text-gray-600 hover:text-gray-900">
                &larr; Back to Hostels
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8">
                <form action="{{ route('hostel.update', $hostel->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Name -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Hostel Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $hostel->name) }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Type -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Hostel Type</label>
                            <select name="type" id="type" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="">Select Type</option>
                                <option value="Boys" {{ old('type', $hostel->type) == 'Boys' ? 'selected' : '' }}>Boys
                                    Hostel</option>
                                <option value="Girls" {{ old('type', $hostel->type) == 'Girls' ? 'selected' : '' }}>Girls
                                    Hostel</option>
                                <option value="Mixed" {{ old('type', $hostel->type) == 'Mixed' ? 'selected' : '' }}>Mixed
                                    Hostel</option>
                            </select>
                            @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Address -->
                        <div class="col-span-2">
                            <label for="address"
                                class="block text-sm font-medium text-gray-700 mb-1">Address/Location</label>
                            <input type="text" name="address" id="address"
                                value="{{ old('address', $hostel->address) }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Warden Name -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="warden_name" class="block text-sm font-medium text-gray-700 mb-1">Warden
                                Name</label>
                            <input type="text" name="warden_name" id="warden_name"
                                value="{{ old('warden_name', $hostel->warden_name) }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>

                        <!-- Warden Contact -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="warden_contact" class="block text-sm font-medium text-gray-700 mb-1">Warden
                                Contact</label>
                            <input type="text" name="warden_contact" id="warden_contact"
                                value="{{ old('warden_contact', $hostel->warden_contact) }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>

                        <!-- Description -->
                        <div class="col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description /
                                Notes</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('description', $hostel->description) }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6 border-t border-gray-100">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                            Update Hostel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-master-layout>