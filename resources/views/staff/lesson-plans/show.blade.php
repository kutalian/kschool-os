<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Lesson Plan Details</h1>
                <p class="text-sm text-gray-500">Review your strategy for: <span
                        class="font-semibold text-gray-700">{{ $lessonPlan->topic }}</span></p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('staff.lesson-plans.edit', $lessonPlan) }}"
                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition flex items-center gap-2">
                    <i class="fas fa-edit text-sm"></i>
                    Edit Plan
                </a>
                <a href="{{ route('staff.lesson-plans.index') }}"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    Back to List
                </a>
            </div>
        </div>

        <div class="max-w-4xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 py-6 border-b border-gray-50">
                        <div>
                            <p class="text-xs text-gray-400 font-bold tracking-widest uppercase mb-1">Class</p>
                            <p class="text-lg font-bold text-gray-800">{{ $lessonPlan->class_room->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold tracking-widest uppercase mb-1">Subject</p>
                            <p class="text-lg font-bold text-gray-800">{{ $lessonPlan->subject->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold tracking-widest uppercase mb-1">Lesson Date</p>
                            <p class="text-lg font-bold text-gray-800">
                                {{ $lessonPlan->week_start_date->format('F d, Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3
                                class="text-sm font-bold text-green-600 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <i class="fas fa-bullseye"></i> Learning Objectives
                            </h3>
                            <div
                                class="bg-green-50 rounded-xl p-6 text-gray-700 leading-relaxed whitespace-pre-line min-h-[150px]">
                                {{ $lessonPlan->objectives ?: 'No objectives specified.' }}
                            </div>
                        </div>
                        <div>
                            <h3
                                class="text-sm font-bold text-blue-600 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <i class="fas fa-tasks"></i> Classroom Activities
                            </h3>
                            <div
                                class="bg-blue-50 rounded-xl p-6 text-gray-700 leading-relaxed whitespace-pre-line min-h-[150px]">
                                {{ $lessonPlan->activities ?: 'No activities specified.' }}
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3
                            class="text-sm font-bold text-orange-600 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <i class="fas fa-home"></i> Homework / Assignment
                        </h3>
                        <div class="bg-orange-50 rounded-xl p-6 text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $lessonPlan->homework ?: 'No homework assigned for this lesson.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-master-layout>