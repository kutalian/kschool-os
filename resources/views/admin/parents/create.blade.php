<x-master-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Add New Parent Profile</h1>
        <p class="text-gray-500">Create a comprehensive parent profile including father, mother, or guardian details.
        </p>
    </div>

    <form action="{{ route('parents.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- 1. Primary Contact Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Primary Contact Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Primary Contact Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    <p class="text-xs text-gray-500 mt-1">This name will be used for system identification.</p>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Primary Email <span
                            class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Primary Phone <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="primary_phone" value="{{ old('primary_phone') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('primary_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Secondary Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Residential Address</label>
                    <textarea name="address" rows="2"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">{{ old('address') }}</textarea>
                </div>
            </div>
        </div>

        <!-- 2. Father's Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Father's Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Father's Name</label>
                    <input type="text" name="father_name" value="{{ old('father_name') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Father's Phone</label>
                    <input type="text" name="father_phone" value="{{ old('father_phone') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Occupation</label>
                    <input type="text" name="father_occupation" value="{{ old('father_occupation') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
            </div>
        </div>

        <!-- 3. Mother's Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Mother's Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Mother's Name</label>
                    <input type="text" name="mother_name" value="{{ old('mother_name') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Mother's Phone</label>
                    <input type="text" name="mother_phone" value="{{ old('mother_phone') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Occupation</label>
                    <input type="text" name="mother_occupation" value="{{ old('mother_occupation') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
            </div>
        </div>

        <!-- 4. Guardian's Details (Optional) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Guardian's Details (If applicable)</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Guardian's Name</label>
                    <input type="text" name="guardian_name" value="{{ old('guardian_name') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Relationship</label>
                    <input type="text" name="guardian_relation" value="{{ old('guardian_relation') }}"
                        placeholder="e.g. Uncle"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Guardian's Phone</label>
                    <input type="text" name="guardian_phone" value="{{ old('guardian_phone') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('parents.index') }}"
                class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">Cancel</a>
            <button type="submit"
                class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm">Save
                Parent Profile</button>
        </div>
    </form>
</x-master-layout>