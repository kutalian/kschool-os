<x-master-layout>
    <div class="fade-in max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('accountant.fees.index') }}"
                class="text-gray-500 hover:text-blue-600 transition mb-2 inline-block">
                <i class="fas fa-arrow-left mr-1"></i> Back to Fees
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Assign Fee to Student</h1>
            <p class="text-gray-500">Create an invoice for a specific student based on a fee type.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('accountant.fees.store_assign') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Student <span
                                class="text-red-500">*</span></label>
                        <select name="student_id" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Choose Student...</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->first_name }} {{ $student->last_name }} ({{ $student->admission_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Fee Type <span
                                class="text-red-500">*</span></label>
                        <select name="fee_type_id" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Choose Fee Structure...</option>
                            @foreach($feeTypes as $type)
                                <option value="{{ $type->id }}">
                                    {{ $type->name }} - ${{ number_format($type->amount, 2) }} ({{ $type->frequency }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Due Date <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="due_date" required min="{{ date('Y-m-d') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit"
                            class="px-6 py-2 rounded-lg bg-gray-800 text-white font-bold hover:bg-gray-700 transition shadow-sm">
                            Generate Invoice
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>