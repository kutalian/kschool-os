<x-master-layout>
    <div class="fade-in">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Financial Dashboard</h1>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
                <div class="rounded-full bg-green-100 p-4 mr-4 text-green-600">
                    <i class="fas fa-coins text-2xl"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-medium">Total Collections</div>
                    <div class="text-2xl font-bold text-gray-800">${{ number_format($totalCollections, 2) }}</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
                <div class="rounded-full bg-blue-100 p-4 mr-4 text-blue-600">
                    <i class="fas fa-calendar-day text-2xl"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-medium">Collected Today</div>
                    <div class="text-2xl font-bold text-gray-800">${{ number_format($todaysCollections, 2) }}</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
                <div class="rounded-full bg-red-100 p-4 mr-4 text-red-600">
                    <i class="fas fa-file-invoice-dollar text-2xl"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500 font-medium">Pending Fees</div>
                    <div class="text-2xl font-bold text-gray-800">${{ number_format($pendingFees, 2) }}</div>
                </div>
            </div>
        </div>

        {{-- Recent Payments --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Recent Payments</h3>
                <a href="{{ route('accountant.payments.index') }}"
                    class="text-sm text-blue-600 hover:text-blue-800 font-semibold">View All &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Transaction
                                ID</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Student</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Method</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentPayments as $payment)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $payment->transaction_id ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $payment->studentFee->student->first_name ?? 'Unknown' }}
                                    {{ $payment->studentFee->student->last_name ?? '' }}
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-green-600">
                                    ${{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ ucfirst($payment->payment_method) }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ ucfirst($payment->status) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">No payments recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-master-layout>