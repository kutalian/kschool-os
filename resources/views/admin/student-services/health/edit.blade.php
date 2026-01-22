<x-master-layout>
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Health Record</h1>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('health-records.update', $healthRecord->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Student</label>
                            <select name="student_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ $student->id == $healthRecord->student_id ? 'selected' : '' }}>
                                        {{ $student->name }} ({{ $student->admission_no }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Record Date</label>
                            <input type="date" name="record_date"
                                value="{{ $healthRecord->record_date->format('Y-m-d') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="record_type"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                @foreach(['Checkup', 'Illness', 'Injury', 'Vaccination', 'Allergy', 'Other'] as $type)
                                    <option value="{{ $type }}" {{ $healthRecord->record_type == $type ? 'selected' : '' }}>
                                        {{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Doctor Name</label>
                            <input type="text" name="doctor_name" value="{{ $healthRecord->doctor_name }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Symptoms</label>
                            <textarea name="symptoms" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $healthRecord->symptoms }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Diagnosis</label>
                            <textarea name="diagnosis" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $healthRecord->diagnosis }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Treatment/Medication</label>
                            <textarea name="treatment" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $healthRecord->treatment }}</textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('health-records.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2 hover:bg-gray-600">Cancel</a>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Update Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-master-layout>