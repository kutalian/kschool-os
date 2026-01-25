<x-master-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Principal Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Total Students -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-600 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Students</dt>
                                <dd class="text-3xl font-semibold text-gray-900">{{ $totalStudents }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Staff -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-600 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Staff</dt>
                                <dd class="text-3xl font-semibold text-gray-900">{{ $totalStaff }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fees Collected -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-600 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Fees Collected</dt>
                                <dd class="text-3xl font-semibold text-gray-900">
                                    ${{ number_format($totalFeesCollected, 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Summary -->
        <h2 class="text-xl font-bold text-gray-800 mb-4">Today's Attendance</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Student Attendance -->
            <div class="bg-white overflow-hidden shadow rounded-lg p-5">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Students</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-3 bg-green-50 rounded text-green-700">
                        <span class="block text-2xl font-bold">{{ $studentAttendance['present'] }}</span>
                        <span class="text-sm">Present</span>
                    </div>
                    <div class="text-center p-3 bg-red-50 rounded text-red-700">
                        <span class="block text-2xl font-bold">{{ $studentAttendance['absent'] }}</span>
                        <span class="text-sm">Absent</span>
                    </div>
                </div>
            </div>

            <!-- Staff Attendance -->
            <div class="bg-white overflow-hidden shadow rounded-lg p-5">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Staff</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-3 bg-blue-50 rounded text-blue-700">
                        <span class="block text-2xl font-bold">{{ $staffAttendance['present'] }}</span>
                        <span class="text-sm">Present</span>
                    </div>
                    <div class="text-center p-3 bg-orange-50 rounded text-orange-700">
                        <span class="block text-2xl font-bold">{{ $staffAttendance['absent'] }}</span>
                        <span class="text-sm">Absent</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links / Stats could go here -->
    </div>
</x-master-layout>