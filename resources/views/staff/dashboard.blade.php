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
                        <i class="fas fa-book-reader text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">My Classes</p>
                        <h3 class="text-xl font-bold text-gray-800">5</h3>
                    </div>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 stat-card">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-orange-50 text-orange-600 rounded-lg">
                        <i class="fas fa-tasks text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Pending Tasks</p>
                        <h3 class="text-xl font-bold text-gray-800">12</h3>
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
                        <p class="text-sm text-gray-500 font-medium">Attendance Taken</p>
                        <h3 class="text-xl font-bold text-gray-800">Completed</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Upcoming Classes</h2>
            <div class="space-y-4">
                <div
                    class="p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-gray-800">Mathematics - Class 10A</h4>
                        <p class="text-sm text-gray-500"><i class="far fa-clock mr-1"></i> 09:00 AM - 10:00 AM</p>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Today</span>
                </div>
                <div
                    class="p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-gray-800">Science - Class 9B</h4>
                        <p class="text-sm text-gray-500"><i class="far fa-clock mr-1"></i> 11:30 AM - 12:30 PM</p>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Today</span>
                </div>
            </div>
        </div>
    </div>
    </x-master-layout>