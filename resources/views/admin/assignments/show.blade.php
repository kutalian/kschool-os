<x-master-layout>
    <div class="container mx-auto px-4 py-6">
        <a href="{{ route('assignments.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">&larr; Back
            to Assignments</a> //

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $assignment->title }}</h1>
                    <div class="text-sm text-gray-500 mb-4">
                        <span class="font-semibold">{{ $assignment->class_room->name }}</span> &bull;
                        <span class="font-semibold">{{ $assignment->subject->name }}</span> &bull;
                        <span>Due: {{ $assignment->due_date->format('M d, Y h:i A') }}</span>
                    </div>
                </div>
                @if($assignment->file_path)
                    <a href="{{ route('assignments.download', $assignment->id) }}"
                        class="bg-blue-100 text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-200 transition flex items-center">
                        <i class="fas fa-download mr-2"></i> Download Attachment
                    </a>
                @endif
            </div>

            <div class="prose max-w-none text-gray-700 mt-4 border-t pt-4">
                {{ $assignment->description }}
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Submissions ({{ $assignment->submissions->count() }})
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                            <th class="py-3 px-6">Student</th>
                            <th class="py-3 px-6">Submitted At</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @forelse($assignment->submissions as $submission)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 font-medium">{{ $submission->student->name ?? 'Unknown' }}
                                    ({{ $submission->student->admission_no ?? '' }})</td>
                                <td class="py-3 px-6">
                                    <span
                                        class="px-2 py-1 rounded {{ $submission->submitted_at->gt($assignment->due_date) ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $submission->submitted_at->format('M d, Y h:i A') }}
                                    </span>
                                    @if($submission->submitted_at->gt($assignment->due_date))
                                        <span class="text-xs text-red-500 ml-1">(Late)</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <a href="{{ Storage::url($submission->file_path) }}" target="_blank"
                                        class="text-blue-600 hover:underline mr-3">View File</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-center text-gray-500">No submissions yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-master-layout>