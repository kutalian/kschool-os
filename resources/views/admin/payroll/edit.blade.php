<x-master-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Payroll Record</h1>
            <p class="text-gray-500">Manual adjustment for {{ $payroll->staff->name }} ({{ $payroll->month }})</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('payroll.update', $payroll->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Salary -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Basic Salary</label>
                        <input type="number" name="basic_salary"
                            value="{{ old('basic_salary', $payroll->basic_salary) }}" min="0" step="0.01" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    </div>

                    <!-- Allowance -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Allowances / Bonus <span
                                class="text-green-600">(+)</span></label>
                        <input type="number" name="allowance" value="{{ old('allowance', $payroll->allowance) }}"
                            min="0" step="0.01" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                        <p class="text-xs text-gray-500 mt-1">Extra pay, transport, medical, etc.</p>
                    </div>

                    <!-- Deduction -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deductions <span
                                class="text-red-600">(-)</span></label>
                        <input type="number" name="deduction" value="{{ old('deduction', $payroll->deduction) }}"
                            min="0" step="0.01" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                        <p class="text-xs text-gray-500 mt-1">Absence, penalties, advance repayment.</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Payment Status</label>
                        <select name="status"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                            <option value="Pending" {{ $payroll->status === 'Pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="Paid" {{ $payroll->status === 'Paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mt-4">
                    <p class="text-sm text-gray-600 text-center">
                        Net Salary will be auto-calculated as: <br>
                        <span class="font-bold">Basic + Allowance - Deduction</span>
                    </p>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('payroll.index') }}"
                        class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">Cancel</a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">
                        Update Payroll
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>