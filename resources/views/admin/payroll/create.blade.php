<x-master-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Generate Monthly Payroll</h1>
            <p class="text-gray-500">Calculate salaries and deductions for all active staff.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('payroll.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Select Month</label>
                    <input type="month" name="month" value="{{ date('Y-m') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-lg p-3">
                    <p class="text-sm text-gray-500 mt-2">
                        <i class="fas fa-info-circle"></i> This will calculate deductions based on attendance records
                        for the selected month.
                    </p>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('payroll.index') }}"
                        class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">Cancel</a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-sm flex items-center">
                        <i class="fas fa-cogs mr-2"></i> Generate Payroll
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>