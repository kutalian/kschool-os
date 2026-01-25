<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Student Dashboard</h1>
            <span class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Stat Card 1 -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 stat-card">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                        <i class="fas fa-percentage text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Attendance</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $attendancePercentage }}%</h3>
                    </div>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 stat-card">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                        <i class="fas fa-star text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">CGPA</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $cgpa }}</h3>
                    </div>
                </div>
            </div>
            <!-- Stat Card 3 -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 stat-card">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-red-50 text-red-600 rounded-lg">
                        <i class="fas fa-file-invoice text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Due Fees</p>
                        <h3 class="text-xl font-bold text-gray-800">${{ number_format($dueFees, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Timetable Widget -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Today's Timetable</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium text-gray-700"> Mathematics</span>
                        <span class="text-sm text-gray-500">09:00 - 10:00</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium text-gray-700">Physics</span>
                        <span class="text-sm text-gray-500">10:15 - 11:15</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium text-gray-700">English</span>
                        <span class="text-sm text-gray-500">11:30 - 12:30</span>
                    </div>
                </div>
            </div>

            <!-- Notices Widget -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Notice Board</h2>
                    <span
                        class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                        {{ $notices->count() }} New
                    </span>
                </div>
                <div class="space-y-4">
                    @forelse($notices as $notice)
                        <div class="pb-3 border-b border-gray-50 last:border-0">
                            <h4 class="text-sm font-bold text-gray-800">{{ $notice->title }}</h4>
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ Str::limit($notice->message, 100) }}</p>
                            <div class="mt-2 flex justify-between items-center">
                                <span class="text-xs text-gray-400">{{ $notice->created_at->diffForHumans() }}</span>
                                @if($notice->priority == 'Urgent')
                                    <span class="text-xs text-red-500 font-bold">Urgent</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-4">
                            <p class="text-sm">No new notices.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-master-layout>