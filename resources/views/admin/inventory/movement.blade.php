<x-master-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Record Movement: {{ $item->item_name }}</h1>
        <a href="{{ route('inventory.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl mx-auto">
        <div class="mb-6 p-4 bg-blue-50 rounded-lg flex justify-between items-center">
            <div>
                <p class="text-sm text-blue-600 font-semibold">Current Stock</p>
                <p class="text-2xl font-bold text-blue-800">{{ $item->quantity }}</p>
            </div>
            <div>
                <p class="text-sm text-blue-600 font-semibold">Location</p>
                <p class="text-lg text-blue-800">{{ $item->location ?? 'N/A' }}</p>
            </div>
        </div>

        <form action="{{ route('inventory.movement.store', $item->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="movement_type" class="block text-sm font-medium text-gray-700 mb-1">Movement Type</label>
                <select name="movement_type" id="movement_type"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                    <option value="">Select Type</option>
                    <option value="In">Stock In (Add)</option>
                    <option value="Out">Stock Out (Remove)</option>
                    <option value="Damaged">Damaged (Remove)</option>
                    <option value="Lost">Lost (Remove)</option>
                    <option value="Return">Return (Add)</option>
                </select>
                @error('movement_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                <input type="number" name="quantity" id="quantity" min="1"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="movement_date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" name="movement_date" id="movement_date" value="{{ date('Y-m-d') }}"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                @error('movement_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason / Notes
                    (Optional)</label>
                <textarea name="reason" id="reason" rows="3"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"></textarea>
                @error('reason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Save Movement
                </button>
            </div>
        </form>
    </div>
</x-master-layout>