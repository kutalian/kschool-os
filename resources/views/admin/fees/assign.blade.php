<x-master-layout>
    @php
        /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\ClassRoom> $classes */
        /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\FeeType> $feeTypes */
        /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Student> $students */
    @endphp
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Assign Fee</h1>
            <p class="text-gray-500">Invoice students for Tuition, Transport, or other fees.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" x-data="{ mode: 'bulk' }">

            <!-- Toggle Mode -->
            <div class="flex space-x-4 border-b border-gray-100 mb-6 pb-2">
                <button @click="mode = 'bulk'"
                    :class="mode === 'bulk' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700'"
                    class="pb-2 font-medium transition-colors">
                    <i class="fas fa-users mr-2"></i> Bulk Assignment (Class)
                </button>
                <button @click="mode = 'individual'"
                    :class="mode === 'individual' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700'"
                    class="pb-2 font-medium transition-colors">
                    <i class="fas fa-user mr-2"></i> Individual Assignment
                </button>
            </div>

            <form action="{{ route('fees.storeAssignment') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Common Fields -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Fee Type</label>
                        <select name="fee_type_id" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                            <option value="">-- Select Fee --</option>
                            @foreach($feeTypes as $fee)
                                <option value="{{ $fee->id }}">
                                    {{ $fee->name }} - ₦{{ number_format($fee->amount, 2) }} ({{ $fee->frequency }})
                                </option>
                            @endforeach
                        </select>
                        @error('fee_type_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Bulk Mode: Class Selection -->
                    <div x-show="mode === 'bulk'" class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Select Class</label>
                        <select name="class_id"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }} {{ $class->section }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Fee will be assigned to all active students in the
                            selected class.</p>
                        @error('class_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Individual Mode: Student Selection -->
                    <div x-show="mode === 'individual'" class="md:col-span-2" style="display: none;">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Select Student</label>
                        <select name="student_id"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                            <option value="">-- Select Student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}
                                    ({{ $student->admission_no }})</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Assign fee to a specific student only.</p>
                        @error('student_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Due Date</label>
                        <input type="date" name="due_date" required min="{{ date('Y-m-d') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                        @error('due_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Academic Session Details -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Academic Year</label>
                        <input type="text" name="academic_year" placeholder="e.g. 2025-2026"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Term (Optional)</label>
                        <select name="term"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                            <option value="">-- Select Term --</option>
                            <option value="Term 1">Term 1</option>
                            <option value="Term 2">Term 2</option>
                            <option value="Term 3">Term 3</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <a href="{{ route('fees.index') }}"
                        class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">Cancel</a>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm">Assign
                        Fee</button>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>