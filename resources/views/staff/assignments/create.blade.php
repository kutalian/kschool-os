<x-master-layout>
    <div class="fade-in">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Create Assignment</h1>
            <p class="text-sm text-gray-500">Provide details for the new student assignment</p>
        </div>

        <div class="max-w-3xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <form action="{{ route('staff.assignments.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="class_id" :value="__('Class')" />
                            <select id="class_id" name="class_id"
                                class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm"
                                required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }} ({{ $class->section ?? 'A' }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('class_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="subject_id" :value="__('Subject')" />
                            <select id="subject_id" name="subject_id"
                                class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm"
                                required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }} ({{ $subject->code }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="title" :value="__('Assignment Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                            :value="old('title')" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Instructions / Description')" />
                        <textarea id="description" name="description" rows="4"
                            class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="due_date" :value="__('Due Date & Time')" />
                            <x-text-input id="due_date" class="block mt-1 w-full" type="datetime-local" name="due_date"
                                :value="old('due_date')" required />
                            <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="file" :value="__('Attached Worksheet (Optional)')" />
                            <input type="file" id="file" name="file"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                            <p class="mt-1 text-xs text-gray-500">PDF, Word, or Images up to 5MB</p>
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50">
                        <a href="{{ route('staff.assignments.index') }}"
                            class="px-4 py-2 text-gray-700 hover:text-gray-900 transition">Cancel</a>
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                            {{ __('Save Assignment') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-master-layout>