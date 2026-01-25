<x-master-layout>
    <div class="fade-in">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Payment History</h1>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('accountant.fees.index') }}" class="text-blue-600 font-semibold hover:text-blue-800">
                    &larr; Back to Invoices
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Transaction
                                ID</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Student</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Fee Type</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Method</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $payment->transaction_id ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $payment->studentFee->student->first_name ?? 'Unknown' }}
                                    {{ $payment->studentFee->student->last_name ?? '' }}
                                    <div class="text-xs text-gray-400">ID:
                                        {{ $payment->studentFee->student->admission_number ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $payment->studentFee->feeType->name ?? 'Custom Fee' }}
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-green-600">
                                    ${{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ ucfirst($payment->payment_method) }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500 italic">
                                    No transaction history found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</x-master-layout>