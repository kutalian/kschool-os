<x-master-layout>
    <div class="flex flex-col items-center justify-center min-h-screen py-6 bg-gray-50">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                    <i class="fas fa-trash-alt text-2xl text-red-600"></i>
                </div>

                <h2 class="text-xl font-bold text-gray-800 mb-2">Delete Assignment?</h2>
                <p class="text-gray-500 mb-6">
                    Are you sure you want to delete the assignment
                    <span class="font-semibold text-gray-800">"{{ $assignment->title }}"</span>?
                    <br>This action will move it to trash.
                </p>

                <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left border border-gray-100">
                    <div class="text-sm">
                        <span class="text-gray-500">Class:</span>
                        <span class="text-gray-800 font-medium ml-2">{{ $assignment->class_room->name ?? 'N/A' }}</span>
                    </div>
                    <div class="text-sm mt-2">
                        <span class="text-gray-500">Subject:</span>
                        <span class="text-gray-800 font-medium ml-2">{{ $assignment->subject->name ?? 'N/A' }}</span>
                    </div>
                    <div class="text-sm mt-2">
                        <span class="text-gray-500">Due Date:</span>
                        <span
                            class="text-gray-800 font-medium ml-2">{{ $assignment->due_date->format('M d, Y') }}</span>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('assignments.index') }}"
                        class="flex-1 bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition font-medium">
                        Cancel
                    </a>

                    <form action="{{ route('assignments.destroy', $assignment->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-medium shadow-sm">
                            Delete Assignment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-master-layout>