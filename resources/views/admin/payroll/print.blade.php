<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip_{{ $payroll->month }}_{{ $payroll->staff->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body class="bg-white text-gray-800 p-8">
    <div class="max-w-3xl mx-auto border border-gray-800 p-8">
        <!-- Header -->
        <div class="text-center border-b-2 border-gray-800 pb-6 mb-8">
            <h1 class="text-4xl font-bold uppercase tracking-wider mb-2">School ERP</h1>
            <p class="text-gray-600 text-sm uppercase font-bold tracking-widest">Payslip for
                {{ \Carbon\Carbon::createFromFormat('Y-m', $payroll->month)->format('F Y') }}</p>
        </div>

        <!-- Details -->
        <div class="flex justify-between mb-8 pb-8 border-b border-gray-300">
            <div>
                <p class="text-xs text-gray-500 uppercase font-bold">Employee</p>
                <h2 class="text-xl font-bold">{{ $payroll->staff->name }}</h2>
                <p>{{ $payroll->staff->role_type }} | ID: {{ $payroll->staff->employee_id }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 uppercase font-bold">Bank Details</p>
                <p>{{ $payroll->staff->bank_name ?? 'N/A' }}</p>
                <p>{{ $payroll->staff->bank_account_no ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Table -->
        <table class="w-full mb-8">
            <thead>
                <tr class="bg-gray-100 text-left border-y border-gray-800">
                    <th class="py-2 pl-4">Description</th>
                    <th class="py-2 text-right pr-4">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr>
                    <td class="py-2 pl-4">Basic Salary</td>
                    <td class="py-2 text-right pr-4">{{ number_format($payroll->basic_salary, 2) }}</td>
                </tr>
                <tr>
                    <td class="py-2 pl-4">Allowances</td>
                    <td class="py-2 text-right pr-4">{{ number_format($payroll->allowance, 2) }}</td>
                </tr>
                <tr class="text-red-600">
                    <td class="py-2 pl-4">Deductions (Absence)</td>
                    <td class="py-2 text-right pr-4">-{{ number_format($payroll->deduction, 2) }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="font-bold text-xl border-t-2 border-gray-800">
                    <td class="py-4 pl-4 pt-4">Net Payable</td>
                    <td class="py-4 text-right pr-4 pt-4">{{ number_format($payroll->net_salary, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer -->
        <div class="mt-12 pt-8 border-t border-gray-300 text-center text-xs text-gray-500">
            <p>This is a computer-generated document.</p>
            <p>Generated on {{ now()->format('d M Y') }}</p>
        </div>
    </div>

    <script>
        window.onload = function () { window.print(); }
    </script>
</body>

</html>