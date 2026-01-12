<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $payment->id }} - School ERP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden print:shadow-none print:max-w-none">

        <!-- Header -->
        <div class="bg-blue-900 text-white p-8 text-center print:bg-blue-900">
            <h1 class="text-3xl font-bold uppercase tracking-wide">School ERP High School</h1>
            <p class="opacity-80 mt-1">123 Education Lane, Academic City, State</p>
            <div class="mt-4 border-t border-blue-800 pt-4 inline-block px-6">
                <span class="text-sm uppercase tracking-widest opacity-60">Money Receipt</span>
            </div>
        </div>

        <div class="p-8">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h2 class="text-gray-500 text-xs uppercase tracking-wider">Receipt To</h2>
                    <h3 class="font-bold text-xl text-gray-800">{{ $payment->studentFee->student->first_name }}
                        {{ $payment->studentFee->student->last_name }}
                    </h3>
                    <p class="text-sm text-gray-600">Admission No: {{ $payment->studentFee->student->admission_no }}</p>
                    <p class="text-sm text-gray-600">Class:
                        {{ $payment->studentFee->student->class_room->name ?? 'N/A' }}
                        {{ $payment->studentFee->student->class_room->section ?? '' }}
                    </p>
                </div>
                <div class="text-right">
                    <h2 class="text-gray-500 text-xs uppercase tracking-wider">Receipt Details</h2>
                    <p class="font-bold text-gray-800">#{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-sm text-gray-600">Date:
                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M, Y') }}
                    </p>
                    <p class="text-sm text-gray-600">Method: {{ $payment->payment_method }}</p>
                </div>
            </div>



            <table class="w-full mb-8">
                <thead>
                    <tr class="bg-gray-50 border-y border-gray-100">
                        <th class="py-3 px-4 text-left text-gray-500 text-xs uppercase tracking-wider">Description</th>
                        <th class="py-3 px-4 text-right text-gray-500 text-xs uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-4 px-4 text-gray-800">
                            {{ $payment->studentFee->feeType->name }} ({{ $payment->studentFee->term ?? 'General' }})
                            @if($payment->remarks)
                                <div class="text-xs text-gray-500 mt-1">{{ $payment->remarks }}</div>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-right font-bold text-gray-800">
                            ₦{{ number_format($payment->amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="border-t border-gray-100 pt-6">
                <div class="flex justify-between items-end">
                    <div class="text-sm text-gray-500">
                        Received By: <span
                            class="font-medium text-gray-800">{{ $payment->receiver->name ?? 'System' }}</span>
                    </div>
                    <div class="text-right space-y-1">
                        <div class="flex justify-end gap-8 text-sm text-gray-500">
                            <span>Total Fee:</span>
                            <span
                                class="font-medium text-gray-800">₦{{ number_format($payment->studentFee->amount, 2) }}</span>
                        </div>
                        <div class="flex justify-end gap-8 text-sm text-gray-500">
                            <span>Total Paid To Date:</span>
                            <span
                                class="font-medium text-green-600">₦{{ number_format($payment->studentFee->paid, 2) }}</span>
                        </div>
                        <div
                            class="flex justify-end gap-8 text-sm font-bold {{ ($payment->studentFee->amount - $payment->studentFee->paid) > 0 ? 'text-red-500' : 'text-gray-400' }}">
                            <span>Balance Due:</span>
                            <span>₦{{ number_format($payment->studentFee->amount - $payment->studentFee->paid, 2) }}</span>
                        </div>

                        <div class="border-t border-gray-100 mt-2 pt-2">
                            <p class="text-xs text-gray-500 uppercase">Paid Now</p>
                            <p class="text-2xl font-bold text-blue-600">₦{{ number_format($payment->amount, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center text-xs text-gray-400 print:fixed print:bottom-8 print:left-0 print:w-full">
                This is a computer generated receipt and does not require a signature.
            </div>
        </div>

        <!-- Print Button -->
        <div class="bg-gray-50 p-4 text-center border-t border-gray-100 no-print">
            <button onclick="window.print()"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition shadow-sm font-medium">
                <i class="fas fa-print mr-2"></i> Print Receipt
            </button>
            <a href="{{ url()->previous() }}"
                class="text-gray-600 hover:text-gray-900 ml-4 font-medium text-sm">Cancel</a>
        </div>
    </div>
</body>

</html>