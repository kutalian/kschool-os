<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Exam Mark Entry</h1>
            <span class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($classes as $class)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition duration-200">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $class->name }}</h3>
                            <p class="text-gray-500">Section: {{ $class->section ?? 'A' }}</p>
                        </div>
                        <div class="p-2 bg-pink-100 text-pink-600 rounded-lg">
                            <i class="fas fa-marker text-xl"></i>
                        </div>
                    </div>

                    <a href="{{ route('staff.marks.create', ['class_id' => $class->id]) }}"
                        class="block w-full py-2 px-4 bg-pink-600 text-white font-semibold rounded-lg text-center hover:bg-pink-700 transition">
                        Enter Marks
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-master-layout>