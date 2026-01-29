<x-master-layout>
    <div class="fade-in">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">New Lesson Plan</h1>
            <p class="text-sm text-gray-500">Document your teaching strategy for a specific class</p>
        </div>

        <div class="max-w-4xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <form action="{{ route('staff.lesson-plans.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <x-input-label for="class_id" :value="__('Class')" />
                            <select id="class_id" name="class_id"
                                class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm"
                                required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="subject_id" :value="__('Subject')" />
                            <select id="subject_id" name="subject_id"
                                class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm"
                                required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="week_start_date" :value="__('Lesson Date')" />
                            <x-text-input id="week_start_date" class="block mt-1 w-full" type="date"
                                name="week_start_date" :value="old('week_start_date', date('Y-m-d'))" required />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="topic" :value="__('Topic Title')" />
                        <x-text-input id="topic" class="block mt-1 w-full" type="text" name="topic"
                            :value="old('topic')" required placeholder="e.g. Introduction to Photosynthesis" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="objectives" :value="__('Learning Objectives')" />
                            <textarea id="objectives" name="objectives" rows="4"
                                class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm"
                                placeholder="What should students learn?">{{ old('objectives') }}</textarea>
                        </div>
                        <div>
                            <x-input-label for="activities" :value="__('Classroom Activities')" />
                            <textarea id="activities" name="activities" rows="4"
                                class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm"
                                placeholder="Steps/Tasks for the lesson">{{ old('activities') }}</textarea>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="homework" :value="__('Homework / Assignment')" />
                        <textarea id="homework" name="homework" rows="2"
                            class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm"
                            placeholder="Optional follow-up work">{{ old('homework') }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50">
                        <a href="{{ route('staff.lesson-plans.index') }}"
                            class="px-4 py-2 text-gray-700 hover:text-gray-900 transition">Cancel</a>
                        <x-primary-button class="bg-green-600 hover:bg-green-700">
                            {{ __('Save Lesson Plan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-master-layout>