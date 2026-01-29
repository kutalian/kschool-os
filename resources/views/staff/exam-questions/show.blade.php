<x-master-layout>
    <div class="fade-in pb-12">
        <div class="mb-6 flex justify-between items-start">
            <div>
                <a href="{{ route('staff.exam-questions.index') }}"
                    class="text-indigo-600 hover:text-indigo-700 text-sm font-medium mb-2 inline-block">
                    <i class="fas fa-arrow-left mr-1"></i> Back to List
                </a>
                <h1 class="text-2xl font-bold text-gray-800">{{ $examQuestion->title }}</h1>
                <p class="text-sm text-gray-500">Submission Details & Review Status</p>
            </div>

            <div class="flex gap-2">
                @if($examQuestion->status === 'pending')
                    <a href="{{ route('staff.exam-questions.edit', $examQuestion) }}"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition flex items-center gap-2">
                        <i class="fas fa-edit text-sm"></i>
                        Edit Submission
                    </a>
                @endif
                @if($examQuestion->file_path)
                    <a href="{{ asset('storage/' . $examQuestion->file_path) }}" target="_blank"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center gap-2">
                        <i class="fas fa-download text-sm"></i>
                        Download File
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-50 pb-2">Questions /
                        Details</h3>
                    <div class="prose max-w-none text-gray-700 whitespace-pre-wrap">
                        {{ $examQuestion->content ?: 'No text content provided. Please check the attached file.' }}
                    </div>
                </div>

                @if($examQuestion->admin_remarks)
                    <div class="bg-red-50 rounded-xl border border-red-100 p-8">
                        <h3 class="text-lg font-semibold text-red-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-comment-dots"></i>
                            Admin Remarks
                        </h3>
                        <p class="text-red-700">{{ $examQuestion->admin_remarks }}</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Metadata</h3>
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Status</span>
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'approved' => 'bg-green-100 text-green-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span
                                class="px-2 py-0.5 font-medium rounded-full {{ $statusClasses[$examQuestion->status] ?? 'bg-gray-100' }}">
                                {{ ucfirst($examQuestion->status) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Class</span>
                            <span class="font-medium text-gray-800">{{ $examQuestion->class_room->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Subject</span>
                            <span class="font-medium text-gray-800">{{ $examQuestion->subject->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Exam</span>
                            <span
                                class="font-medium text-gray-800">{{ $examQuestion->exam->name ?? 'None Specified' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Submitted On</span>
                            <span
                                class="font-medium text-gray-800">{{ $examQuestion->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                @if($examQuestion->file_path)
                    <div class="bg-indigo-50 rounded-xl border border-indigo-100 p-6">
                        <h3 class="text-sm font-semibold text-indigo-800 uppercase tracking-wider mb-4">Attachment</h3>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-file-pdf text-3xl text-indigo-400"></i>
                            <div class="overflow-hidden">
                                <p class="text-xs font-medium text-indigo-900 truncate">
                                    {{ basename($examQuestion->file_path) }}</p>
                                <a href="{{ asset('storage/' . $examQuestion->file_path) }}" target="_blank"
                                    class="text-xs text-indigo-600 hover:underline">View Document</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-master-layout>