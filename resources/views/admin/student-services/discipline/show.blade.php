<x-master-layout>
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Disciplinary Record Details</h1>
            <a href="{{ route('disciplinary-records.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i> Back to List
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Student Information</h3>
                        <p class="mb-2"><span class="font-bold text-gray-700">Name:</span>
                            {{ $disciplinaryRecord->student->name }}</p>
                        <p class="mb-2"><span class="font-bold text-gray-700">Admission No:</span>
                            {{ $disciplinaryRecord->student->admission_no }}</p>
                        <p class="mb-2"><span class="font-bold text-gray-700">Class:</span>
                            {{ $disciplinaryRecord->student->class_room->name ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Incident Details</h3>
                        <p class="mb-2"><span class="font-bold text-gray-700">Date:</span>
                            {{ $disciplinaryRecord->incident_date->format('M d, Y') }}</p>
                        <p class="mb-2"><span class="font-bold text-gray-700">Type:</span> <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ $disciplinaryRecord->incident_type }}</span>
                        </p>
                        <p class="mb-2"><span class="font-bold text-gray-700">Action Taken:</span>
                            {{ $disciplinaryRecord->action_taken }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Description</h3>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            {{ $disciplinaryRecord->description }}
                        </div>
                    </div>

                    @if($disciplinaryRecord->remarks)
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Remarks</h3>
                            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100 text-sm">
                                {{ $disciplinaryRecord->remarks }}
                            </div>
                        </div>
                    @endif

                    <div class="md:col-span-2 mt-4 border-t pt-4">
                        <div class="flex justify-between text-sm text-gray-500">
                            <p>Recorded By: {{ $disciplinaryRecord->reporter->name ?? 'N/A' }}</p>
                            <p>Parent Notified:
                                @if($disciplinaryRecord->parent_notified)
                                    <span class="text-green-600 font-bold"><i class="fas fa-check"></i> Yes</span>
                                @else
                                    <span class="text-red-600 font-bold"><i class="fas fa-times"></i> No</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex space-x-4">
            <a href="{{ route('disciplinary-records.edit', $disciplinaryRecord->id) }}"
                class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-4 rounded-lg text-center transition duration-200">
                <i class="fas fa-edit mr-2"></i> Edit Record
            </a>
            <form action="{{ route('disciplinary-records.destroy', $disciplinaryRecord->id) }}" method="POST"
                class="flex-1" onsubmit="return confirm('Are you sure you want to delete this record?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-trash-alt mr-2"></i> Delete Record
                </button>
            </form>
        </div>
    </div>
</x-master-layout>