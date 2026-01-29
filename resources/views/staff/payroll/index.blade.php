<x-master-layout>
    <div class="fade-in">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">My Payroll</h1>
            <p class="text-sm text-gray-500">View your payment history and download payslips</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Month/Year</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Net Salary</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Payment Date</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($payrollHistory as $payroll)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">{{ $payroll->month }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-800">{{ number_format($payroll->net_salary, 2) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700">{{ $payroll->payment_date ? (is_string($payroll->payment_date) ? $payroll->payment_date : $payroll->payment_date->format('M d, Y')) : 'Pending' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-bold rounded-full uppercase tracking-wider {{ $payroll->status === 'Paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $payroll->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('staff.payroll.show', $payroll) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm transition flex items-center justify-end gap-1">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                        View Payslip
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    No payroll records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($payrollHistory->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $payrollHistory->links() }}
                </div>
            @endif
        </div>
    </div>
</x-master-layout>
