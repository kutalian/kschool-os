<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Staff Dashboard</h1>
            <span class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Stat Card 1 -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 stat-card">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                        <i class="fas fa-chalkboard-teacher text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">My Homeroom Classes</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $myClasses->count() }}</h3>
                    </div>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 stat-card">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-orange-50 text-orange-600 rounded-lg">
                        <i class="fas fa-user-graduate text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Students</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $totalStudents }}</h3>
                    </div>
                </div>
            </div>
            <!-- Stat Card 3 -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 stat-card">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-pink-50 text-pink-600 rounded-lg">
                        <i class="fas fa-calendar-check text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Attendance</p>
                        <h3 class="text-xl font-bold text-gray-800">Check</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">My Homeroom Classes</h2>
            @if($myClasses->isEmpty())
                <div class="text-center py-6 text-gray-500">
                    <i class="fas fa-info-circle mb-2 text-2xl"></i>
                    <p>You have not been assigned as a Class Teacher for any class yet.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($myClasses as $class)
                        <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-lg">{{ $class->name }}</h4>
                                    <p class="text-sm text-gray-600">Section: {{ $class->section ?? 'N/A' }}</p>
                                </div>
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Homeroom</span>
                            </div>
                            <div class="mt-4 flex space-x-2">
                                <a href="#"
                                    class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white text-sm py-2 px-3 rounded shadow transition">
                                    <i class="fas fa-users mr-1"></i> Students
                                </a>
                                <a href="#"
                                    class="flex-1 text-center bg-green-600 hover:bg-green-700 text-white text-sm py-2 px-3 rounded shadow transition">
                                    <i class="fas fa-clipboard-check mr-1"></i> Attendance
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-master-layout>