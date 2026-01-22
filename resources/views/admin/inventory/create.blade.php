<x-master-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Add Inventory Item</h1>
        <a href="{{ route('inventory.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl mx-auto">
        <form action="{{ route('inventory.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="item_name" class="block text-sm font-medium text-gray-700 mb-1">Item Name</label>
                <input type="text" name="item_name" id="item_name"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                @error('item_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Initial Quantity</label>
                <input type="number" name="quantity" id="quantity" min="0"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location (Optional)</label>
                <input type="text" name="location" id="location"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description
                    (Optional)</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Save Item
                </button>
            </div>
        </form>
    </div>
</x-master-layout>