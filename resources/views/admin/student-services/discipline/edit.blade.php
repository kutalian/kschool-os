<x-master-layout>
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Disciplinary Record</h1>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('disciplinary-records.update', $disciplinaryRecord->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Student</label>
                            <select name="student_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ $student->id == $disciplinaryRecord->student_id ? 'selected' : '' }}>
                                        {{ $student->name }} ({{ $student->admission_no }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Incident Date</label>
                            <input type="date" name="incident_date"
                                value="{{ $disciplinaryRecord->incident_date->format('Y-m-d') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Incident Type</label>
                            <select name="incident_type"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                @foreach(['Misconduct', 'Fighting', 'Bullying', 'Absence', 'Late', 'Uniform', 'Other'] as $type)
                                    <option value="{{ $type }}" {{ $disciplinaryRecord->incident_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Action Taken</label>
                            <select name="action_taken"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                @foreach(['Warning', 'Detention', 'Suspension', 'Expulsion', 'Counseling', 'Parent Meeting'] as $action)
                                    <option value="{{ $action }}" {{ $disciplinaryRecord->action_taken == $action ? 'selected' : '' }}>{{ $action }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>{{ $disciplinaryRecord->description }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Remarks (Optional)</label>
                            <textarea name="remarks" rows="2"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $disciplinaryRecord->remarks }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="parent_notified" value="1" {{ $disciplinaryRecord->parent_notified ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Parent Notified</span>
                            </label>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('disciplinary-records.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2 hover:bg-gray-600">Cancel</a>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Update
                            Incident</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-master-layout>