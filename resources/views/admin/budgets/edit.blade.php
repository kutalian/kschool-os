<x-master-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Budget Allocation</h1>
        <a href="{{ route('budgets.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6 max-w-2xl mx-auto">
        <form action="{{ route('budgets.update', $budget->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="academic_year" class="block text-sm font-medium text-gray-700">Academic Year</label>
                <input type="text" name="academic_year" id="academic_year" value="{{ $budget->academic_year }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 cursor-not-allowed">
            </div>

            <div class="mb-4">
                <label for="category" class="block text-sm font-medium text-gray-700">Expense Category <span
                        class="text-red-500">*</span></label>
                <input list="category_options" name="category" id="category" value="{{ $budget->category }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Type or select category..." required>
                <datalist id="category_options">
                    @foreach($categories as $category)
                        <option value="{{ $category }}">
                    @endforeach
                </datalist>
            </div>

            <div class="mb-4">
                <label for="allocated_amount" class="block text-sm font-medium text-gray-700">Allocated Amount <span
                        class="text-red-500">*</span></label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="text-gray-500 sm:text-sm">₦</span>
                    </div>
                    <input type="number" name="allocated_amount" id="allocated_amount"
                        value="{{ $budget->allocated_amount }}" min="0" step="0.01"
                        class="block w-full rounded-md border-gray-300 pl-7 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        placeholder="0.00" required>
                </div>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700">Description / Notes</label>
                <textarea name="description" id="description" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $budget->description }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Update Allocation
                </button>
            </div>
        </form>
    </div>
</x-master-layout>