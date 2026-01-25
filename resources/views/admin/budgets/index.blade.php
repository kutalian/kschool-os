<x-master-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Budget Management ({{ $currentYear }})</h1>
        <a href="{{ route('budgets.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i> Allocate Budget
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($budgets as $budget)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $budget->category }}</h3>
                        <p class="text-sm text-gray-500">{{ $budget->academic_year }}</p>
                    </div>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 hidden"
                            :class="{ 'hidden': !open }">
                            <a href="{{ route('budgets.edit', $budget->id) }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                            <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Spent: {{ number_format($budget->spent_amount, 2) }}</span>
                        <span class="font-semibold text-gray-900">Total:
                            {{ number_format($budget->allocated_amount, 2) }}</span>
                    </div>
                    @php
                        $percentage = $budget->percentage_used;
                        $colorClass = $percentage > 100 ? 'bg-red-500' : ($percentage > 80 ? 'bg-yellow-500' : 'bg-green-500');
                    @endphp
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="{{ $colorClass }} h-2.5 rounded-full" style="width: {{ min($percentage, 100) }}%"></div>
                    </div>
                    <p class="text-xs text-right mt-1 {{ $percentage > 100 ? 'text-red-600 font-bold' : 'text-gray-500' }}">
                        {{ $percentage }}% Used
                    </p>
                </div>

                <div class="flex justify-between items-center text-sm border-t pt-4">
                    <span class="text-gray-500">Remaining</span>
                    <span
                        class="font-bold text-gray-800 {{ $budget->allocated_amount - $budget->spent_amount < 0 ? 'text-red-600' : '' }}">
                        {{ number_format($budget->allocated_amount - $budget->spent_amount, 2) }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $budgets->links() }}
    </div>
</x-master-layout>