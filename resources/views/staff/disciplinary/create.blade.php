<x-master-layout>
    <div class="fade-in">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Report Disciplinary Incident</h1>
            <p class="text-sm text-gray-500">Document a behavioral issue involving a student</p>
        </div>

        <div class="max-w-3xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <form action="{{ route('staff.disciplinary.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="student_id" :value="__('Student')" />
                        <select id="student_id" name="student_id"
                            class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg shadow-sm"
                            required>
                            <option value="">Search Student...</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ (old('student_id') == $student->id || request('student_id') == $student->id) ? 'selected' : '' }}>
                                    {{ $student->user->name }} (Roll: {{ $student->roll_number }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="incident_date" :value="__('Incident Date')" />
                            <x-text-input id="incident_date" class="block mt-1 w-full" type="date" name="incident_date"
                                :value="old('incident_date', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('incident_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="incident_type" :value="__('Incident Type')" />
                            <select id="incident_type" name="incident_type"
                                class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg shadow-sm"
                                required>
                                <option value="">Select Type</option>
                                <option value="Misbehavior" {{ old('incident_type') == 'Misbehavior' ? 'selected' : '' }}>
                                    Misbehavior</option>
                                <option value="Bullying" {{ old('incident_type') == 'Bullying' ? 'selected' : '' }}>
                                    Bullying</option>
                                <option value="Academic Dishonesty" {{ old('incident_type') == 'Academic Dishonesty' ? 'selected' : '' }}>Academic Dishonesty</option>
                                <option value="Attendance Issue" {{ old('incident_type') == 'Attendance Issue' ? 'selected' : '' }}>Attendance Issue</option>
                                <option value="Property Damage" {{ old('incident_type') == 'Property Damage' ? 'selected' : '' }}>Property Damage</option>
                                <option value="Other" {{ old('incident_type') == 'Other' ? 'selected' : '' }}>Other
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('incident_type')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Incident Description')" />
                        <textarea id="description" name="description" rows="5"
                            class="mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-lg shadow-sm"
                            placeholder="Provide detailed information about what happened..."
                            required>{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50">
                        <a href="{{ route('staff.disciplinary.index') }}"
                            class="px-4 py-2 text-gray-700 hover:text-gray-900 transition">Cancel</a>
                        <x-primary-button class="bg-orange-600 hover:bg-orange-700">
                            {{ __('Submit Report') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-master-layout>