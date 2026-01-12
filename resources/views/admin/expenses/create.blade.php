<x-master-layout>
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Add New Expense</h1>
            <a href="{{ route('expenses.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                <i class="fas fa-times mr-1"></i> Cancel
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Expense Date</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                        <select name="category_id" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Amount (₦)</label>
                    <input type="number" step="0.01" name="amount" required placeholder="0.00"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition text-lg font-bold">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Reference No. (Optional)</label>
                        <input type="text" name="reference_no" placeholder="e.g. INV-001"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Incurred By (Optional)</label>
                        <input type="text" name="incurred_by" placeholder="Person name"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description / Notes</label>
                    <textarea name="description" rows="3" placeholder="Additional details..."
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-bold shadow-md">
                    <i class="fas fa-check-circle mr-2"></i> Record Expense
                </button>
            </form>
        </div>
    </div>
</x-master-layout>