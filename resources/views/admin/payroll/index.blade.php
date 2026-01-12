<x-master-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Payroll Management</h1>
            <p class="text-gray-500">Manage monthly salaries and payslips.</p>
        </div>
        <a href="{{ route('payroll.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i> Generate Payroll
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <form action="{{ route('payroll.index') }}" method="GET" class="flex items-end gap-4">
            <div class="flex-1">
                <label class="block text-gray-700 text-sm font-bold mb-2">Filter by Month</label>
                <input type="month" name="month" value="{{ $month }}"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                    onchange="this.form.submit()">
            </div>
            <div class="flex-none">
                <button type="submit"
                    class="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">Filter</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 tracking-wider">
                    <th class="p-4 font-semibold">Staff Name</th>
                    <th class="p-4 font-semibold">Month</th>
                    <th class="p-4 font-semibold text-right">Basic Salary</th>
                    <th class="p-4 font-semibold text-right">Deductions</th>
                    <th class="p-4 font-semibold text-right">Net Salary</th>
                    <th class="p-4 font-semibold text-center">Status</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($payrolls as $payroll)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4">
                            <div class="font-bold text-gray-800">{{ $payroll->staff->name }}</div>
                            <div class="text-xs text-gray-500">{{ $payroll->staff->employee_id }}</div>
                        </td>
                        <td class="p-4 text-gray-600">{{ $payroll->month }}</td>
                        <td class="p-4 text-right font-mono text-gray-700">{{ number_format($payroll->basic_salary, 2) }}
                        </td>
                        <td class="p-4 text-right font-mono text-red-600">-{{ number_format($payroll->deduction, 2) }}</td>
                        <td class="p-4 text-right font-mono font-bold text-green-700">
                            {{ number_format($payroll->net_salary, 2) }}
                        </td>
                        <td class="p-4 text-center">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-semibold {{ $payroll->status === 'Paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $payroll->status }}
                            </span>
                        </td>
                        <td class="p-4 text-right gap-2">
                            <a href="{{ route('payroll.edit', $payroll->id) }}"
                                class="text-indigo-600 hover:text-indigo-800 text-sm font-medium mr-2"><i
                                    class="fas fa-edit"></i></a>
                            <a href="{{ route('payroll.show', $payroll->id) }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium mr-2">View</a>
                            <a href="{{ route('payroll.print', $payroll->id) }}" target="_blank"
                                class="text-gray-600 hover:text-gray-800 text-sm font-medium"><i
                                    class="fas fa-print"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-400">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-file-invoice-dollar text-4xl mb-3 text-gray-300"></i>
                                <p>No payroll records found for this month.</p>
                                <a href="{{ route('payroll.create') }}" class="mt-2 text-blue-600 hover:underline">Generate
                                    Payroll</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-master-layout>