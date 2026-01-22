<x-master-layout>
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Add Vaccination Record</h1>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('vaccinations.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Student</label>
                            <select name="student_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->admission_no }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Vaccine Name</label>
                            <input type="text" name="vaccine_name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dose Number</label>
                            <input type="number" name="dose_number" value="1" min="1"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Vaccination Date</label>
                            <input type="date" name="vaccination_date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Next Dose Date (Optional)</label>
                            <input type="date" name="next_dose_date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Hospital/Clinic Name</label>
                            <input type="text" name="hospital_name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('vaccinations.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2 hover:bg-gray-600">Cancel</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save
                            Vaccination</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-master-layout>