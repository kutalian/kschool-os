<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">My Classes</h1>
            <span class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</span>
        </div>

        @if($homeroomClasses->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4 border-l-4 border-blue-500 pl-3">Homeroom Classes
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($homeroomClasses as $class)
                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition duration-200">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800">{{ $class->name }}</h3>
                                    <p class="text-gray-500">Section: {{ $class->section ?? 'A' }}</p>
                                </div>
                                <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                                    <i class="fas fa-chalkboard-teacher text-xl"></i>
                                </div>
                            </div>
                            <div class="mb-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Class
                                    Teacher</span>
                            </div>
                            <a href="{{ route('staff.classes.show', $class->id) }}"
                                class="block w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg text-center hover:bg-blue-700 transition">
                                View Class
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-700 mb-4 border-l-4 border-emerald-500 pl-3">Teaching Classes
            </h2>
            @if($classes->isEmpty())
                <div class="bg-white rounded-xl shadow-sm p-8 text-center border border-gray-100">
                    <div class="text-gray-300 mb-4">
                        <i class="fas fa-book-open text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No Scheduled Classes</h3>
                    <p class="text-gray-500">You are not scheduled to teach any classes currently.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($classes as $class)
                        {{-- Skip if already shown in Homeroom (though controller merges, view separation is nice) --}}
                        @if(!$homeroomClasses->contains('id', $class->id))
                            <div
                                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition duration-200">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-800">{{ $class->name }}</h3>
                                        <p class="text-gray-500">Section: {{ $class->section ?? 'A' }}</p>
                                    </div>
                                    <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg">
                                        <i class="fas fa-book text-xl"></i>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <span
                                        class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-2.5 py-0.5 rounded">Subject
                                        Teacher</span>
                                </div>
                                <a href="{{ route('staff.classes.show', $class->id) }}"
                                    class="block w-full py-2 px-4 bg-emerald-600 text-white font-semibold rounded-lg text-center hover:bg-emerald-700 transition">
                                    View Class
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-master-layout>