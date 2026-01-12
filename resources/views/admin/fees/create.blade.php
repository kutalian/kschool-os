<x-master-layout>
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Create Fee Type</h1>
            <p class="text-gray-500">Define a new fee structure (e.g., Tuition, Transport, Lab Fee)</p>
        </div>

        <form action="{{ route('fees.store') }}" method="POST"
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Fee Name -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Fee Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                        placeholder="e.g. 1st Term Tuition">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Frequency -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Frequency</label>
                    <select name="frequency" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                        <option value="One-Time" {{ old('frequency') == 'One-Time' ? 'selected' : '' }}>One-Time</option>
                        <option value="Monthly" {{ old('frequency') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="Quarterly" {{ old('frequency') == 'Quarterly' ? 'selected' : '' }}>Quarterly
                            (Termly)</option>
                        <option value="Annually" {{ old('frequency') == 'Annually' ? 'selected' : '' }}>Annually</option>
                    </select>
                    @error('frequency') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Amount -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Amount (₦)</label>
                    <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" required min="0"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                        placeholder="e.g. 50000.00">
                    @error('amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                        placeholder="Brief details about this fee...">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Active Status -->
                <div class="md:col-span-2 mt-2">
                    <label class="flex items-center space-x-3">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}
                            class="form-checkbox h-5 w-5 text-blue-600 rounded">
                        <span class="text-gray-700 font-medium">Fee is Active</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('fees.index') }}"
                    class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">Cancel</a>
                <button type="submit"
                    class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm">Save
                    Fee Type</button>
            </div>
        </form>
    </div>
</x-master-layout>