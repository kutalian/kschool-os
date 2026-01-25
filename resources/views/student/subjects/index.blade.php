<x-master-layout>
    <div class="fade-in">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">My Subjects</h1>
            <p class="text-gray-500">Class: <span class="font-semibold">{{ $classRoom->name }}
                    ({{ $classRoom->section }})</span></p>
        </div>

        @if($subjects->isEmpty())
            <div class="bg-white rounded-xl shadow-sm p-8 text-center border border-gray-100">
                <div class="text-gray-300 mb-4">
                    <i class="fas fa-book-open text-6xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">No Subjects Assigned</h3>
                <p class="text-gray-500">There are no subjects assigned to your class yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($subjects as $subject)
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition duration-200 flex flex-col h-full">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">{{ $subject->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $subject->code }}</p>
                            </div>
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                                <i class="fas fa-book text-xl"></i>
                            </div>
                        </div>

                        <div class="mb-4 flex-grow">
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class="fas fa-layer-group w-5 text-gray-400"></i>
                                <span>Type: {{ ucfirst($subject->type) }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-clock w-5 text-gray-400"></i>
                                <span>Credits: {{ $subject->credit_hours }}</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-4 mt-auto">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Syllabus / Resources</h4>
                            @if(isset($syllabi[$subject->id]) && $syllabi[$subject->id]->count() > 0)
                                <ul class="space-y-2">
                                    @foreach($syllabi[$subject->id] as $syllabus)
                                        <li
                                            class="flex items-center justify-between text-sm bg-gray-50 p-2 rounded hover:bg-gray-100 transition">
                                            <div class="flex items-center overflow-hidden">
                                                <i class="fas fa-file-alt text-red-500 mr-2 flex-shrink-0"></i>
                                                <span class="truncate" title="{{ $syllabus->title }}">{{ $syllabus->title }}</span>
                                            </div>
                                            @if($syllabus->file_path)
                                                <a href="{{ Storage::url($syllabus->file_path) }}" target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 ml-2" title="Download">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-xs text-gray-400 italic">No syllabus uploaded.</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-master-layout>