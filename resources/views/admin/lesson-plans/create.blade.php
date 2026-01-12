<x-master-layout>
    @php
        /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\ClassRoom[] $classes */
        /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Subject[] $subjects */
    @endphp
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Create Lesson Plan</h1>

        <div class="bg-white rounded-lg shadow p-6 max-w-3xl">
            <form action="{{ route('lesson-plans.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Whoops!</strong>
                        <span class="block sm:inline">There were some problems with your input.</span>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                        <select name="class_id" id="class_id" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <select name="subject_id" id="subject_id" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="week_start_date" class="block text-sm font-medium text-gray-700 mb-1">Week Start
                        Date</label>
                    <input type="date" name="week_start_date" id="week_start_date" required
                        value="{{ old('week_start_date') }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Please select the Monday of the week.</p>
                </div>

                <div class="mb-4">
                    <label for="topic" class="block text-sm font-medium text-gray-700 mb-1">Topic / Unit</label>
                    <input type="text" name="topic" id="topic" required value="{{ old('topic') }}"
                        placeholder="e.g. Introduction to Algebra"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="objectives" class="block text-sm font-medium text-gray-700 mb-1">Learning
                        Objectives</label>
                    <textarea name="objectives" id="objectives" rows="4" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="What will students learn?">{{ old('objectives') }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="resources_needed" class="block text-sm font-medium text-gray-700 mb-1">Resources Needed
                        (Optional)</label>
                    <textarea name="resources_needed" id="resources_needed" rows="3"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Materials, books, or equipment required.">{{ old('resources_needed') }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="attachment" class="block text-sm font-medium text-gray-700 mb-1">Attachment (PDF, Doc,
                        Image) - Optional</label>
                    <input type="file" name="attachment" id="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-1">Max file size: 2MB</p>
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('lesson-plans.index') }}"
                        class="text-gray-600 hover:text-gray-800 font-medium mr-4">Cancel</a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition">
                        Submit Plan
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-master-layout>