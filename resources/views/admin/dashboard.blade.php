<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
            <span class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Students -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 stat-card">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Students</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ number_format($stats['students']) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Total Staff -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 stat-card">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-teal-50 text-teal-600 rounded-lg">
                        <i class="fas fa-chalkboard-teacher text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Staff</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ number_format($stats['staff']) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Total Parents -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 stat-card">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-purple-50 text-purple-600 rounded-lg">
                        <i class="fas fa-user-friends text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Parents</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ number_format($stats['parents']) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Total Classes -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 stat-card">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                        <i class="fas fa-layer-group text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Classes</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ number_format($stats['classes']) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Admissions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Admissions</h2>
                <div class="space-y-4">
                    @forelse($recentStudents as $student)
                        <div class="flex items-start gap-3 pb-4 border-b border-gray-50 last:border-0 last:pb-0">
                            <div
                                class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                                {{ substr($student->first_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm text-gray-800 font-medium">{{ $student->first_name }}
                                    {{ $student->last_name }}</p>
                                <p class="text-xs text-gray-500">Admitted to Class {{ $student->classRoom->name ?? 'N/A' }}
                                </p>
                            </div>
                            <span class="ml-auto text-xs text-gray-400">{{ $student->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No recent admissions.</p>
                    @endforelse
                </div>
            </div>

            <!-- Attendance Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Today's Attendance</h2>
                @if($attendanceStats['total'] > 0)
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-green-600">{{ $attendanceStats['present'] }}</span>
                            <span class="text-xs text-gray-500">Present</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-red-500">{{ $attendanceStats['absent'] }}</span>
                            <span class="text-xs text-gray-500">Absent</span>
                        </div>
                        <div class="text-center">
                            <span
                                class="block text-2xl font-bold text-blue-600">{{ $attendanceStats['percentage'] }}%</span>
                            <span class="text-xs text-gray-500">Attendance Rate</span>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $attendanceStats['percentage'] }}%">
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-3">
                            <i class="fas fa-clipboard-list text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 text-sm">No attendance taken today.</p>
                        <a href="{{ route('attendance.create') }}"
                            class="text-blue-600 text-sm font-medium hover:underline mt-2 inline-block">Take Attendance</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-master-layout>