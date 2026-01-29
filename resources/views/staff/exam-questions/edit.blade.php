<x-master-layout>
    <div class="fade-in pb-12">
        <div class="mb-6 flex justify-between items-start">
            <div>
                <a href="{{ route('staff.exam-questions.index') }}"
                    class="text-indigo-600 hover:text-indigo-700 text-sm font-medium mb-2 inline-block">
                    <i class="fas fa-arrow-left mr-1"></i> Back to List
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Edit Submission</h1>
                <p class="text-sm text-gray-500">Update your question paper details</p>
            </div>
        </div>

        @if($examQuestion->admin_remarks)
            <div class="max-w-4xl mb-6">
                <div class="bg-red-50 border border-red-100 rounded-xl p-4 text-sm text-red-700 flex items-center gap-3">
                    <i class="fas fa-info-circle text-red-400"></i>
                    <div>
                        <span class="font-bold">Admin Feedback:</span> {{ $examQuestion->admin_remarks }}
                    </div>
                </div>
            </div>
        @endif

        <div class="max-w-4xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <form action="{{ route('staff.exam-questions.update', $examQuestion) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Class Selection -->
                        <div>
                            <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                            <select name="class_id" id="class_id" required
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id', $examQuestion->class_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Subject Selection -->
                        <div>
                            <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <select name="subject_id" id="subject_id" required
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition">
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id', $examQuestion->subject_id) == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subject_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Exam Selection -->
                        <div>
                            <label for="exam_id" class="block text-sm font-medium text-gray-700 mb-1">Exam
                                (Optional)</label>
                            <select name="exam_id" id="exam_id"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition">
                                <option value="">Select Exam</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ old('exam_id', $examQuestion->exam_id) == $exam->id ? 'selected' : '' }}>
                                        {{ $exam->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('exam_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title / Paper
                                Name</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $examQuestion->title) }}"
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition">
                            @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Questions /
                            Description</label>
                        <textarea name="content" id="content" rows="6"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition">{{ old('content', $examQuestion->content) }}</textarea>
                        @error('content') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Update Question Paper
                            (Leave blank to keep current)</label>
                        @if($examQuestion->file_path)
                            <div class="mb-2 text-xs text-gray-500 flex items-center gap-2">
                                <i class="fas fa-file-alt"></i>
                                <span>Current file: {{ basename($examQuestion->file_path) }}</span>
                            </div>
                        @endif
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-file-upload text-gray-400 text-3xl mb-3"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label for="file"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Upload new file</span>
                                        <input id="file" name="file" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1 text-gray-500">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PDF, DOC, DOCX up to 10MB
                                </p>
                            </div>
                        </div>
                        @error('file') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('staff.exam-questions.index') }}"
                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-md transition flex items-center gap-2">
                            <i class="fas fa-save text-sm"></i>
                            Update Submission
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-master-layout>