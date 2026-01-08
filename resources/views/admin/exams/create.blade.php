<x-master-layout>
    {{-- @var \Illuminate\Database\Eloquent\Collection|\App\Models\ClassRoom[] $classes --}}

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Create New Exam</h1>
    </div>

    <form action="{{ route('exams.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Exam Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Exam Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        placeholder="e.g. First Term Mathematics"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Type -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Exam Type</label>
                    <select name="exam_type" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                        <option value="Mid-Term">Mid-Term</option>
                        <option value="Final">Final</option>
                        <option value="Quiz">Quiz</option>
                        <option value="Test">Test</option>
                        <option value="Assignment">Assignment</option>
                    </select>
                    @error('exam_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Class -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Class</label>
                    <select name="class_id" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                        <option value="">-- Select Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} - {{ $class->section }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Academic Year -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Academic Year</label>
                    <input type="text" name="academic_year" value="{{ old('academic_year', date('Y')) }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <!-- Start Date -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- End Date -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('exams.index') }}"
                class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">Cancel</a>
            <button type="submit"
                class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm">Create
                Exam</button>
        </div>
    </form>
</x-master-layout>