<x-master-layout>
    <div class="max-w-6xl mx-auto" x-data="{ 
        paymentModalOpen: false, 
        selectedFee: null,
        openPaymentModal(fee, studentName) {
            this.selectedFee = fee;
            this.paymentModalOpen = true;
        }
    }">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Collect Fees</h1>
            <p class="text-gray-500">Record fee payments for students.</p>
        </div>

        <!-- Student Search Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <form action="{{ route('fees.collect') }}" method="GET" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Select Student</label>
                    <select name="student_id"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                        onchange="this.form.submit()">
                        <option value="">-- Search Student --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ (isset($selectedStudent) && $selectedStudent->id == $student->id) ? 'selected' : '' }}>
                                {{ $student->first_name }} {{ $student->last_name }} ({{ $student->admission_no }}) -
                                {{ $student->class_room->name ?? 'No Class' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm h-[42px]">
                        <i class="fas fa-search mr-2"></i> Find
                    </button>
                </div>
            </form>
        </div>

        @if($selectedStudent)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Student Profile Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:col-span-1">
                    <div class="text-center">
                        <div
                            class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-600">
                            @if($selectedStudent->profile_pic)
                                <img src="{{ asset('storage/' . $selectedStudent->profile_pic) }}"
                                    class="w-full h-full object-cover rounded-full">
                            @else
                                <i class="fas fa-user-graduate text-3xl"></i>
                            @endif
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $selectedStudent->first_name }}
                            {{ $selectedStudent->last_name }}
                        </h2>
                        <p class="text-gray-500 text-sm">{{ $selectedStudent->admission_no }}</p>
                        <div class="mt-4 border-t border-gray-100 pt-4 text-left text-sm space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Class:</span>
                                <span class="font-medium">{{ $selectedStudent->class_room->name ?? 'N/A' }}
                                    {{ $selectedStudent->class_room->section ?? '' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Parent:</span>
                                <span class="font-medium">{{ $selectedStudent->parent->father_name ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Unpaid Fees List -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden md:col-span-2">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                        <h3 class="font-bold text-gray-800">Pending Invoices</h3>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paid</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Balance</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($fees as $fee)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $fee->feeType->name }}
                                        <div class="text-xs text-gray-500">{{ $fee->term }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($fee->due_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">₦{{ number_format($fee->amount, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-green-600">₦{{ number_format($fee->paid, 2) }}</td>
                                    <td class="px-6 py-4 text-sm font-bold text-red-600">
                                        ₦{{ number_format($fee->amount - $fee->paid, 2) }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <button @click="openPaymentModal({{ $fee }}, '{{ $selectedStudent->first_name }}')"
                                            class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs font-medium shadow-sm">
                                            Pay Now
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <i class="fas fa-check-circle text-green-500 text-4xl mb-3 block"></i>
                                        No pending fees found for this student.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Payment History -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden md:col-span-3 mt-6">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                        <h3 class="font-bold text-gray-800">Payment History</h3>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Receipt #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($payments as $payment)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $payment->studentFee->feeType->name }}
                                        <span class="text-xs text-gray-400">({{ $payment->studentFee->term }})</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-green-600">
                                        ₦{{ number_format($payment->amount, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $payment->payment_method }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('fees.receipt', $payment->id) }}" target="_blank"
                                            class="px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 text-xs font-medium shadow-sm transition">
                                            <i class="fas fa-print mr-1"></i> Receipt
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        No payments recorded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif(request('student_id'))
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 text-yellow-700">
                <p>Student not found or no student selected.</p>
            </div>
        @endif

        <!-- Payment Modal -->
        <div x-show="paymentModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <div x-show="paymentModalOpen" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                    @click="paymentModalOpen = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="paymentModalOpen" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">

                    <form action="{{ route('fees.pay') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="student_fee_id" :value="selectedFee?.id">

                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <i class="fas fa-money-bill-wave text-green-600"></i>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Record
                                        Payment</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 mb-4">
                                            Enter payment details for <span x-text="selectedFee?.fee_type?.name"
                                                class="font-bold"></span>.
                                            Remaining Balance: <span class="font-bold text-red-600"
                                                x-text="'₦' + (selectedFee ? (selectedFee.amount - selectedFee.paid).toFixed(2) : '0.00')"></span>
                                        </p>

                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Amount
                                                    (₦)</label>
                                                <input type="number" name="amount" step="0.01" required min="1"
                                                    :max="selectedFee ? (selectedFee.amount - selectedFee.paid) : 0"
                                                    :value="selectedFee ? (selectedFee.amount - selectedFee.paid) : 0"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Payment
                                                    Method</label>
                                                <select name="payment_method"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                                    <option value="Cash">Cash</option>
                                                    <option value="Bank Transfer">Bank Transfer</option>
                                                    <option value="Online">Online / POS</option>
                                                    <option value="Cheque">Cheque</option>
                                                </select>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Payment Receipt /
                                                    Proof (Image/PDF)</label>
                                                <input type="file" name="payment_proof" accept=".jpg,.jpeg,.png,.pdf"
                                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                                <p class="text-xs text-gray-400 mt-1">Optional. Upload bank receipt or
                                                    transfer proof.</p>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Remarks
                                                    (Optional)</label>
                                                <textarea name="remarks" rows="2"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                    placeholder="Transaction ID or notes..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Confirm Payment
                            </button>
                            <button @click="paymentModalOpen = false" type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-master-layout>