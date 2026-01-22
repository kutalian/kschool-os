<x-master-layout>
    <div class="flex items-center justify-center min-h-[80vh]">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 max-w-lg w-full text-center">

            <!-- Warning Icon -->
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-yellow-100 mb-6">
                <svg class="h-10 w-10 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Confirm Deletion</h2>
            <p class="text-gray-500 mb-6">Are you sure you want to delete this disciplinary record?</p>

            <!-- Record Card -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left border border-gray-100">
                <div class="flex items-center">
                    <div
                        class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold mr-3">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">{{ $disciplinaryRecord->incident_type }}</h3>
                        <p class="text-sm text-gray-500">Student: {{ $disciplinaryRecord->student->name }}</p>
                        <p class="text-xs text-gray-400">Date:
                            {{ $disciplinaryRecord->incident_date->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Warning Box -->
            <div class="bg-red-50 border border-red-100 rounded-lg p-4 mb-8 text-left">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Warning:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>This action cannot be undone. The record will be permanently removed.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex space-x-4">
                <a href="{{ route('disciplinary-records.index') }}"
                    class="w-1/2 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Cancel
                </a>
                <form action="{{ route('disciplinary-records.destroy', $disciplinaryRecord->id) }}" method="POST"
                    class="w-1/2">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-trash-alt mr-2"></i> Delete
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-master-layout>