<x-master-layout>
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Payslip Details</h1>
            <div class="flex gap-3">
                <a href="{{ route('payroll.index') }}"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">Back</a>
                <a href="{{ route('payroll.print', $payroll->id) }}" target="_blank"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-print mr-2"></i> Print Payslip
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="bg-slate-800 text-white p-8 text-center">
                <h2 class="text-3xl font-bold mb-2">SCHOOL ERP</h2>
                <p class="text-blue-200 uppercase tracking-widest text-sm font-semibold">Salary Slip for
                    {{ \Carbon\Carbon::createFromFormat('Y-m', $payroll->month)->format('F Y') }}</p>
            </div>

            <div class="p-8">
                <!-- Employee Info -->
                <div class="grid grid-cols-2 gap-8 mb-8 pb-8 border-b border-gray-200">
                    <div>
                        <p class="text-gray-500 text-sm uppercase font-bold tracking-wider mb-1">Employee Name</p>
                        <p class="text-lg font-bold text-gray-800">{{ $payroll->staff->name }}</p>
                        <p class="text-gray-600">{{ $payroll->staff->employee_id }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500 text-sm uppercase font-bold tracking-wider mb-1">Designation</p>
                        <p class="text-lg font-bold text-gray-800">{{ $payroll->staff->role_type }}</p>
                        <p class="text-gray-600">{{ $payroll->staff->bank_name ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Salary Details -->
                <div class="grid grid-cols-2 gap-x-12 gap-y-4 mb-8">
                    <div class="space-y-4">
                        <h3 class="font-bold text-gray-800 pb-2 border-b border-gray-200">Earnings</h3>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Basic Salary</span>
                            <span class="font-bold text-gray-800">{{ number_format($payroll->basic_salary, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Allowances</span>
                            <span class="font-bold text-gray-800">{{ number_format($payroll->allowance, 2) }}</span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <h3 class="font-bold text-gray-800 pb-2 border-b border-gray-200">Deductions</h3>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Absence Deduction</span>
                            <span class="font-bold text-red-600">-{{ number_format($payroll->deduction, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Net Pay -->
                <div class="bg-gray-50 rounded-lg p-6 flex justify-between items-center border border-gray-200">
                    <div>
                        <p class="text-gray-500 text-sm font-bold uppercase">Net Salary Payable</p>
                        <p class="text-xs text-gray-400">Total earnings - Total deductions</p>
                    </div>
                    <div class="text-3xl font-bold text-green-700">
                        {{ number_format($payroll->net_salary, 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-master-layout>