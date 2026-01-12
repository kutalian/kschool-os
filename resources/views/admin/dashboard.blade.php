<x-master-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-500 mt-1">Welcome back, {{ Auth::user()->name }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-500">{{ now()->format('l, F j, Y') }}</p>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Students -->
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition">
                <div class="absolute right-0 top-0 h-full w-1/2 bg-gradient-to-l from-blue-50/50 to-transparent"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="p-3 bg-blue-100 rounded-xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">
                            <i class="fas fa-user-graduate text-xl"></i>
                        </div>
                        <span
                            class="text-xs font-semibold px-2 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $stats['students'] }}</h3>
                    <p class="text-sm text-gray-500 font-medium">Total Students</p>
                </div>
            </div>

            <!-- Total Staff -->
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition">
                <div class="absolute right-0 top-0 h-full w-1/2 bg-gradient-to-l from-purple-50/50 to-transparent">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="p-3 bg-purple-100 rounded-xl text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition">
                            <i class="fas fa-chalkboard-teacher text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $stats['staff'] }}</h3>
                    <p class="text-sm text-gray-500 font-medium">Total Staff</p>
                </div>
            </div>

            <!-- Monthly Income -->
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition">
                <div class="absolute right-0 top-0 h-full w-1/2 bg-gradient-to-l from-green-50/50 to-transparent"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="p-3 bg-green-100 rounded-xl text-green-600 group-hover:bg-green-600 group-hover:text-white transition">
                            <i class="fas fa-wallet text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold px-2 py-1 bg-blue-100 text-blue-700 rounded-full">This
                            Month</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1">
                        ₦{{ number_format($monthlyCollection / 1000, 1) }}k</h3>
                    <p class="text-sm text-gray-500 font-medium">Fees Collected</p>
                </div>
            </div>

            <!-- Monthly Expenses -->
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition">
                <div class="absolute right-0 top-0 h-full w-1/2 bg-gradient-to-l from-red-50/50 to-transparent"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="p-3 bg-red-100 rounded-xl text-red-600 group-hover:bg-red-600 group-hover:text-white transition">
                            <i class="fas fa-receipt text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold px-2 py-1 bg-orange-100 text-orange-700 rounded-full">This
                            Month</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1">₦{{ number_format($monthlyExpenses / 1000, 1) }}k
                    </h3>
                    <p class="text-sm text-gray-500 font-medium">Total Expenses</p>
                </div>
            </div>
        </div>

        <!-- Charts & Activity Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Left: Financial Chart -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Financial Overview</h3>
                    <div class="flex items-center space-x-2 text-sm">
                        <span class="flex items-center"><span
                                class="w-3 h-3 rounded-full bg-blue-500 mr-2"></span>Income</span>
                        <span class="flex items-center"><span
                                class="w-3 h-3 rounded-full bg-red-400 mr-2"></span>Expense</span>
                    </div>
                </div>
                <div class="relative h-72 w-full">
                    <canvas id="financeChart"></canvas>
                </div>
            </div>

            <!-- Right: Today's Attendance -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Today's Attendance</h3>

                <div class="flex-1 flex flex-col justify-center items-center py-4">
                    <div class="relative h-40 w-40 mb-4">
                        <canvas id="attendanceChart"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center flex-col pointer-events-none">
                            <span class="text-2xl font-bold text-gray-800">{{ $attendanceStats['percentage'] }}%</span>
                            <span class="text-xs text-gray-500 uppercase tracking-wide">Present</span>
                        </div>
                    </div>

                    <div class="w-full grid grid-cols-2 gap-4 mt-4">
                        <div class="text-center p-3 bg-green-50 rounded-xl">
                            <p class="text-2xl font-bold text-green-600">{{ $attendanceStats['present'] }}</p>
                            <p class="text-xs text-green-600 font-medium uppercase">Present</p>
                        </div>
                        <div class="text-center p-3 bg-red-50 rounded-xl">
                            <p class="text-2xl font-bold text-red-600">{{ $attendanceStats['absent'] }}</p>
                            <p class="text-xs text-red-600 font-medium uppercase">Absent</p>
                        </div>
                    </div>
                </div>

                @if($attendanceStats['total'] == 0)
                    <div class="mt-4 text-center">
                        <a href="{{ route('attendance.create') }}"
                            class="inline-flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Take Attendance Now
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Activity & Quick Links -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Students -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Recent Admissions</h3>
                    <a href="{{ route('students.index') }}"
                        class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr
                                class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                <th class="pb-3 pl-2">Student Name</th>
                                <th class="pb-3">Class</th>
                                <th class="pb-3">Admission No</th>
                                <th class="pb-3 text-right pr-2">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($recentStudents as $student)
                                <tr class="group hover:bg-gray-50 transition">
                                    <td class="py-3 pl-2 flex items-center">
                                        <div
                                            class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs mr-3">
                                            {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $student->first_name }}
                                                {{ $student->last_name }}</p>
                                        </div>
                                    </td>
                                    <td class="py-3 text-sm text-gray-500">
                                        {{ $student->class_room->name ?? 'N/A' }}
                                        @if(isset($student->class_room->section))
                                            <span
                                                class="text-xs bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded">{{ $student->class_room->section }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-sm text-gray-500 font-mono">{{ $student->admission_no }}</td>
                                    <td class="py-3 text-sm text-gray-400 text-right pr-2">
                                        {{ $student->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('students.create') }}"
                        class="flex items-center p-3 rounded-xl bg-gray-50 hover:bg-blue-50 hover:text-blue-600 transition group">
                        <div
                            class="h-10 w-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-500 group-hover:text-blue-600 mr-4">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <span class="font-medium text-gray-700 group-hover:text-blue-700">Add New Student</span>
                    </a>

                    <a href="{{ route('fees.collect') }}"
                        class="flex items-center p-3 rounded-xl bg-gray-50 hover:bg-green-50 hover:text-green-600 transition group">
                        <div
                            class="h-10 w-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-500 group-hover:text-green-600 mr-4">
                            <i class="fas fa-cash-register"></i>
                        </div>
                        <span class="font-medium text-gray-700 group-hover:text-green-700">Collect Fees</span>
                    </a>

                    <a href="{{ route('expenses.create') }}"
                        class="flex items-center p-3 rounded-xl bg-gray-50 hover:bg-red-50 hover:text-red-600 transition group">
                        <div
                            class="h-10 w-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-500 group-hover:text-red-600 mr-4">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <span class="font-medium text-gray-700 group-hover:text-red-700">Record Expense</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Finance Chart (Bar)
        const ctxFinance = document.getElementById('financeChart').getContext('2d');
        new Chart(ctxFinance, {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Income',
                    data: @json($chartData['revenue']),
                    backgroundColor: '#3B82F6',
                    borderRadius: 4,
                }, {
                    label: 'Expense',
                    data: @json($chartData['expenses']),
                    backgroundColor: '#F87171',
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [2, 4], color: '#f3f4f6' },
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Attendance Chart (Doughnut)
        const ctxAttendance = document.getElementById('attendanceChart').getContext('2d');
        new Chart(ctxAttendance, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent'],
                datasets: [{
                    data: [{{ $attendanceStats['present'] }}, {{ $attendanceStats['absent'] }}],
                    backgroundColor: ['#10B981', '#EF4444'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { display: false }
                }
            }
        });
    </script>
</x-master-layout>