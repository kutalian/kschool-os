<x-master-layout>
    <div class="fade-in">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Fee Management</h1>
            <div class="flex gap-3 mt-4 md:mt-0">
                <a href="{{ route('accountant.fees.assign') }}"
                    class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition flex items-center">
                    <i class="fas fa-file-invoice-dollar mr-2"></i> Assign Fee (Invoice)
                </a>
                <a href="{{ route('accountant.fees.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center">
                    <i class="fas fa-plus mr-2"></i> New Fee Type
                </a>
            </div>
        </div>

        {{-- Fee Types Grid --}}
        <h2 class="text-lg font-bold text-gray-700 mb-4">Fee Structures</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @forelse($feeTypes as $type)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="text-lg font-bold text-gray-800">{{ $type->name }}</div>
                        <span
                            class="text-xs font-semibold px-2 py-1 bg-blue-50 text-blue-600 rounded-full">{{ $type->frequency }}</span>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2">${{ number_format($type->amount, 2) }}</div>
                    <p class="text-sm text-gray-500 mb-4">{{ Str::limit($type->description, 50) }}</p>
                    <div class="flex justify-end gap-2 text-sm">
                        {{-- Edit/Delete actions could go here --}}
                        <span class="text-gray-400 text-xs mt-1">ID: {{ $type->id }}</span>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-3 text-center py-8 text-gray-500 italic bg-white rounded-xl border border-dashed border-gray-300">
                    No fee types defined yet. Create one to get started.
                </div>
            @endforelse
        </div>

        {{-- Recent Invoices --}}
        <h2 class="text-lg font-bold text-gray-700 mb-4">Recent Invoices (Student Fees)</h2>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Student</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Fee Type</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Due Date</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentInvoices as $invoice)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">
                                        {{ $invoice->student->first_name ?? 'Unknown' }}
                                        {{ $invoice->student->last_name ?? '' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        ID: {{ $invoice->student->admission_number ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $invoice->feeType->name ?? 'Custom Fee' }}
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-800">
                                    ${{ number_format($invoice->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($invoice->status == 'Paid')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Paid</span>
                                    @elseif($invoice->status == 'Partial')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Partial</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">{{ $invoice->status }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-right">
                                    @if($invoice->status != 'Paid')
                                        <a href="{{ route('accountant.payments.create', ['invoice_id' => $invoice->id]) }}"
                                            class="text-blue-600 hover:text-blue-900 font-semibold text-xs border border-blue-200 bg-blue-50 px-3 py-1 rounded hover:bg-blue-100 transition">
                                            Pay
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs">Completed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">No invoices found. Assign
                                    fees to students to generate invoices.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-master-layout>