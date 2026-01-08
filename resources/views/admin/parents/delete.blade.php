<x-master-layout>
    <div class="flex items-center justify-center min-h-[80vh]">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 max-w-lg w-full text-center">

            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-yellow-100 mb-6">
                <svg class="h-10 w-10 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">Delete Parent Record?</h2>

            @if($studentsCount > 0)
                <p class="text-red-600 font-bold mb-6">Action Blocked: Related students found.</p>
            @else
                <p class="text-gray-500 mb-6">Are you sure you want to delete this parent?</p>
            @endif

            <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left border border-gray-100">
                <div class="flex items-center">
                    <div
                        class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mr-3">
                        {{ substr($parent->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">{{ $parent->name }}</h3>
                        <p class="text-sm text-gray-500">Phone: {{ $parent->primary_phone }}</p>
                    </div>
                </div>
            </div>

            <div class="text-left mb-6">
                <h4 class="text-sm font-bold text-yellow-700 mb-2 flex items-center">
                    <i class="fas fa-link mr-2"></i> Related Records:
                </h4>
                <div
                    class="bg-yellow-50 rounded-lg p-3 border border-yellow-100 flex justify-between items-center text-yellow-800">
                    <div class="flex items-center">
                        <i class="fas fa-user-graduate mr-3"></i>
                        <span>Linked Students</span>
                    </div>
                    <span
                        class="bg-yellow-200 text-yellow-900 py-1 px-3 rounded-full text-xs font-bold">{{ $studentsCount }}</span>
                </div>
            </div>

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
                            @if($studentsCount > 0)
                                <p>You <strong>CANNOT</strong> delete this parent because they have linked students. Please
                                    unlink or delete the students first.</p>
                            @else
                                <p>This will permanently delete the parent profile and their <strong>User Account</strong>.
                                    This action cannot be undone.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex space-x-4">
                <a href="{{ route('parents.index') }}"
                    class="w-1/2 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Cancel
                </a>

                @if($studentsCount == 0)
                    <form action="{{ route('parents.destroy', $parent->id) }}" method="POST" class="w-1/2">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                            <i class="fas fa-trash-alt mr-2"></i> Delete All
                        </button>
                    </form>
                @else
                    <button type="button"
                        class="w-1/2 bg-red-300 text-white font-bold py-3 px-4 rounded-lg cursor-not-allowed" disabled>
                        <i class="fas fa-lock mr-2"></i> Locked
                    </button>
                @endif
            </div>

        </div>
    </div>
</x-master-layout>