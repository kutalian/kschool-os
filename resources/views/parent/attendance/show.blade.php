<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <a href="{{ route('parent.children.index') }}"
                    class="text-gray-500 hover:text-blue-600 transition mb-2 inline-block">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Children
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Attendance: {{ $student->first_name }}
                    {{ $student->last_name }}</h1>
            </div>
            <div>
                <form method="GET" action="{{ route('parent.attendance.show', $student->id) }}" class="flex gap-2">
                    <select name="month"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                    <select name="year"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @for($i = now()->year; $i >= now()->year - 2; $i--)
                            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Filter
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
            {{-- Stats Cards --}}
            @php
                $present = $attendances->where('status', 'present')->count();
                $absent = $attendances->where('status', 'absent')->count();
                $late = $attendances->where('status', 'late')->count();
                $totalDays = \Carbon\Carbon::create($year, $month)->daysInMonth; // Or count of working days if valid
                $attendancePercentage = ($attendances->count() > 0) ? ($present / $attendances->count()) * 100 : 0;
            @endphp

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center">
                <div class="rounded-full bg-green-100 p-3 mr-4 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Present</div>
                    <div class="text-xl font-bold text-gray-800">{{ $present }}</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center">
                <div class="rounded-full bg-red-100 p-3 mr-4 text-red-600">
                    <i class="fas fa-times-circle text-xl"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Absent</div>
                    <div class="text-xl font-bold text-gray-800">{{ $absent }}</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center">
                <div class="rounded-full bg-yellow-100 p-3 mr-4 text-yellow-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Late</div>
                    <div class="text-xl font-bold text-gray-800">{{ $late }}</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center">
                <div class="rounded-full bg-blue-100 p-3 mr-4 text-blue-600">
                    <i class="fas fa-chart-pie text-xl"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Attendance %</div>
                    <div class="text-xl font-bold text-gray-800">{{ number_format($attendancePercentage, 1) }}%</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Day</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Computed By
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @for($d = 1; $d <= \Carbon\Carbon::create($year, $month)->daysInMonth; $d++)
                            @php
                                $date = \Carbon\Carbon::create($year, $month, $d);
                                $dateStr = $date->format('Y-m-d');
                                $record = $attendances->firstWhere('date', $dateStr);
                                $isWeekend = $date->isWeekend();
                            @endphp
                            <tr class="hover:bg-gray-50 transition {{ $isWeekend ? 'bg-gray-50' : '' }}">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $date->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $date->format('l') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($record)
                                        @if($record->status == 'present')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Present</span>
                                        @elseif($record->status == 'absent')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Absent</span>
                                        @elseif($record->status == 'late')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Late</span>
                                        @elseif($record->status == 'excused')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Excused</span>
                                        @endif
                                    @else
                                        @if($isWeekend)
                                            <span class="text-gray-400 italic">Weekend</span>
                                        @elseif($date > now())
                                            <span class="text-gray-300">-</span>
                                        @else
                                            <span class="text-gray-400 italic">No record</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $record->recorder->name ?? '-' }}
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-master-layout>