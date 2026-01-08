<x-master-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Parent</h1>
        <p class="text-gray-500">Update profile for {{ $parent->name }}</p>
    </div>

    <form action="{{ route('parents.update', $parent->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Parent Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Full Name (Primary Guardian)</label>
                    <input type="text" name="name" value="{{ old('name', $parent->name) }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Email -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $parent->email) }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Phone -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Primary Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $parent->phone) }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Address -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                    <input type="text" name="address" value="{{ old('address', $parent->address) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Father Name -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Father Contact Name (Optional)</label>
                    <input type="text" name="father_name" value="{{ old('father_name', $parent->father_name) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <!-- Mother Name -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Mother Contact Name (Optional)</label>
                    <input type="text" name="mother_name" value="{{ old('mother_name', $parent->mother_name) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('parents.index') }}"
                class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">Cancel</a>
            <button type="submit"
                class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm">Update
                Parent</button>
        </div>
    </form>
</x-master-layout>