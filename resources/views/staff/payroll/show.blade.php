<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Payslip Detail</h1>
                <p class="text-sm text-gray-500">Payslip for the month of {{ $payroll->month }}</p>
            </div>
            <div class="flex gap-2">
                <button onclick="window.print()"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
                    <i class="fas fa-print text-sm"></i>
                    Print Payslip
                </button>
                <a href="{{ route('staff.payroll.index') }}"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    Back to List
                </a>
            </div>
        </div>

        <div class="max-w-4xl mx-auto">
            <div id="payslip-container"
                class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden p-10">
                <!-- Payslip Header -->
                <div class="flex justify-between items-start border-b-2 border-gray-100 pb-8 mb-8">
                    <div>
                        <h2 class="text-3xl font-extrabold text-blue-600 uppercase tracking-tighter">Payslip</h2>
                        <p class="text-gray-500 font-medium">Month: {{ $payroll->month }}</p>
                    </div>
                    <div class="text-right">
                        <h3 class="text-xl font-bold text-gray-800 tracking-tight">
                            {{ $settings->school_name ?? 'School ERP' }}</h3>
                        <p class="text-sm text-gray-500 max-w-xs ml-auto">
                            {{ $settings->school_address ?? 'School Address' }}</p>
                    </div>
                </div>

                <!-- Employee Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-10">
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Employee Details
                        </p>
                        <h4 class="text-lg font-bold text-gray-800">{{ $staff->user->name }}</h4>
                        <p class="text-sm text-gray-600">ID: {{ $staff->staff_id }}</p>
                        <p class="text-sm text-gray-600">Designation: {{ $staff->designation }}</p>
                    </div>
                    <div class="md:text-right">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Payment Info</p>
                        <p class="text-sm text-gray-600">Payment Date:
                            {{ $payroll->payment_date ? (is_string($payroll->payment_date) ? $payroll->payment_date : $payroll->payment_date->format('M d, Y')) : 'Pending' }}
                        </p>
                        <p class="text-sm text-gray-600">Status: <span
                                class="font-bold text-green-600">{{ $payroll->status }}</span></p>
                        @if($staff->account_number)
                            <p class="text-sm text-gray-600">A/C: {{ Str::mask($staff->account_number, '*', 4, -4) }}</p>
                        @endif
                    </div>
                </div>

                <!-- Earnings & Deductions -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0 border-t border-b border-gray-100 mb-10">
                    <div class="md:border-r border-gray-100 p-6">
                        <h5 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Earnings</h5>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Basic Salary</span>
                                <span
                                    class="font-medium text-gray-800">{{ number_format($payroll->basic_salary, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Allowances</span>
                                <span
                                    class="font-medium text-gray-800">{{ number_format($payroll->allowance, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h5 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Deductions</h5>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Deductions</span>
                                <span
                                    class="font-medium text-red-600">-{{ number_format($payroll->deduction, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grand Total -->
                <div class="bg-blue-600 rounded-xl p-6 text-white flex justify-between items-center shadow-md">
                    <div>
                        <h5 class="text-xs font-bold text-blue-200 uppercase tracking-widest">Net Salary Payable</h5>
                        <p class="text-sm opacity-80">(Basic + Allowances - Deductions)</p>
                    </div>
                    <div class="text-3xl font-extrabold tracking-tighter">
                        {{ number_format($payroll->net_salary, 2) }}
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-12 text-center text-[10px] text-gray-400 uppercase tracking-widest font-medium italic">
                    This is a computer-generated payslip and does not require a signature.
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #payslip-container,
            #payslip-container * {
                visibility: visible !important;
            }

            #payslip-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none;
                border: none;
                padding: 0;
            }

            .sidebar,
            header,
            .flex.gap-2 {
                display: none !important;
            }
        }
    </style>
</x-master-layout>