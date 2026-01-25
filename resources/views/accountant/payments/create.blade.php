<x-master-layout>
    <div class="fade-in max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('accountant.fees.index') }}"
                class="text-gray-500 hover:text-blue-600 transition mb-2 inline-block">
                <i class="fas fa-arrow-left mr-1"></i> Cancel & Back to Invoices
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Record Payment</h1>
            <p class="text-gray-500">
                Receiving payment for
                <span class="font-semibold text-gray-800">{{ $invoice->student->first_name }}
                    {{ $invoice->student->last_name }}</span>
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            {{-- Invoice Summary --}}
            <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-200">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 block">Fee Type</span>
                        <span class="font-semibold text-gray-900">{{ $invoice->feeType->name ?? 'Custom Fee' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Total Amount</span>
                        <span class="font-semibold text-gray-900">${{ number_format($invoice->amount, 2) }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Already Paid</span>
                        <span class="font-semibold text-green-600">${{ number_format($invoice->paid, 2) }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Balance Due</span>
                        <span
                            class="font-bold text-red-600">${{ number_format($invoice->amount - $invoice->paid, 2) }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('accountant.payments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="student_fee_id" value="{{ $invoice->id }}">

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Amount ($) <span
                                class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="amount"
                            value="{{ old('amount', $invoice->amount - $invoice->paid) }}" required min="0.01"
                            max="{{ $invoice->amount - $invoice->paid }}"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Date <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method <span
                                class="text-red-500">*</span></label>
                        <select name="payment_method" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Online">Online</option>
                            <option value="POS">POS / Card</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Transaction ID / Reference
                            (Optional)</label>
                        <input type="text" name="transaction_id" value="{{ old('transaction_id') }}"
                            placeholder="e.g. TRX-123456"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit"
                            class="px-6 py-2 rounded-lg bg-green-600 text-white font-bold hover:bg-green-700 transition shadow-sm">
                            Confirm Payment & Update Balance
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>