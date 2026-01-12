<x-master-layout>
    <div class="flex items-center justify-center min-h-[80vh]">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 max-w-lg w-full text-center">

            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100 mb-6">
                <svg class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">Delete Expense?</h2>
            <p class="text-gray-500 mb-6">Are you sure you want to delete this expense record? This action cannot be
                undone.</p>

            <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-bold text-gray-800">{{ $expense->reference_no ?? 'No Reference' }}</span>
                    <span
                        class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ $expense->category->name }}</span>
                </div>
                <div class="text-lg font-bold text-gray-900 mb-1">
                    ₦{{ number_format($expense->amount, 2) }}
                </div>
                <div class="text-sm text-gray-600">
                    <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                    {{ $expense->date->format('M d, Y') }}
                </div>
                @if($expense->description)
                    <div class="mt-2 text-sm text-gray-500 italic border-l-2 border-gray-200 pl-2">
                        "{{ $expense->description }}"
                    </div>
                @endif
            </div>

            <div class="flex space-x-4">
                <a href="{{ route('expenses.index') }}"
                    class="w-1/2 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Cancel
                </a>

                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="w-1/2">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-trash-alt mr-2"></i> Confirm Delete
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-master-layout>