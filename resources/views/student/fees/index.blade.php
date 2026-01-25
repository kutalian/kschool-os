<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
             <div>
                <h1 class="text-2xl font-bold text-gray-800">My Fees</h1>
                <p class="text-gray-500">{{ $student->first_name }} {{ $student->last_name }}</p>
            </div>
             <div class="flex gap-2">
                 <button
                    class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg font-semibold transition shadow-sm"
                    onclick="window.print()">
                    <i class="fas fa-print mr-1"></i> Print Statement
                </button>
            </div>
        </div>

        @if($fees->isEmpty())
             <div class="bg-white rounded-xl shadow-sm p-8 text-center border border-gray-100">
                <div class="text-gray-300 mb-4">
                    <i class="fas fa-receipt text-6xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">No Fee Records</h3>
                <p class="text-gray-500">There are no fee records available for you.</p>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Fee Type</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Due Date</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Amount</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Paid</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Balance</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php
                                $totalAmount = 0;
                                $totalPaid = 0;
                                $totalBalance = 0;
                            @endphp
                            @foreach($fees as $fee)
                                @php
                                    $balance = $fee->amount - $fee->paid;
                                    $totalAmount += $fee->amount;
                                    $totalPaid += $fee->paid;
                                    $totalBalance += $balance;
                                    $isOverdue = $fee->status != 'paid' && \Carbon\Carbon::parse($fee->due_date)->isPast();
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $fee->feeType->name ?? 'Tuition Fee' }}
                                        <div class="text-xs text-gray-400 font-normal">{{ $fee->academic_year }} - Term {{ $fee->term }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($fee->due_date)->format('M d, Y') }}
                                        @if($isOverdue)
                                            <span class="block text-xs text-red-500 font-bold mt-1">Overdue</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-right text-gray-900 font-semibold">
                                        ${{ number_format($fee->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-right text-green-600">
                                        ${{ number_format($fee->paid, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-right text-red-600 font-bold">
                                        ${{ number_format($balance, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($fee->status == 'paid')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">PAID</span>
                                        @elseif($fee->status == 'partial')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">PARTIAL</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">UNPAID</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray-50 font-bold border-t border-gray-200">
                                <td class="px-6 py-4 text-gray-800" colspan="2">TOTAL OUTSTANDING</td>
                                <td class="px-6 py-4 text-right text-gray-800">${{ number_format($totalAmount, 2) }}</td>
                                <td class="px-6 py-4 text-right text-green-600">${{ number_format($totalPaid, 2) }}</td>
                                <td class="px-6 py-4 text-right text-red-600 text-lg">${{ number_format($totalBalance, 2) }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-8 bg-blue-50 border border-blue-100 rounded-xl p-6 flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-lg font-bold text-blue-900">Need to pay fees?</h3>
                    <p class="text-blue-700 text-sm">Please contact the school admin office or use the parent portal link if your parents have online payment enabled.</p>
                </div>
            </div>
        @endif
    </div>
</x-master-layout>
