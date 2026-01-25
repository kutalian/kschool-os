<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <a href="{{ route('staff.attendance.index') }}"
                    class="text-gray-500 hover:text-blue-600 transition mb-2 inline-block">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Classes
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Attendance Report: {{ $classRoom->name }}
                    ({{ $classRoom->section }})</h1>
            </div>
            <div>
                <form method="GET" action="{{ route('staff.attendance.report') }}" class="flex gap-2">
                    <input type="hidden" name="class_id" value="{{ $classRoom->id }}">
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

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-4 py-3 font-bold text-gray-700 min-w-[150px] sticky left-0 bg-gray-50 z-10">
                                Student Name</th>
                            @for($d = 1; $d <= \Carbon\Carbon::create($year, $month)->daysInMonth; $d++)
                                <th class="px-1 py-3 text-center text-xs font-semibold text-gray-500 min-w-[30px]">
                                    {{ $d }}<br>
                                    <span
                                        class="text-[10px] font-normal">{{ \Carbon\Carbon::create($year, $month, $d)->format('D') }}</span>
                                </th>
                            @endfor
                            <th class="px-4 py-3 font-bold text-gray-700 text-center">Total P</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($students as $student)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900 sticky left-0 bg-white z-10">
                                    {{ $student->first_name }} {{ $student->last_name }}
                                </td>
                                @php $presentCount = 0; @endphp
                                @for($d = 1; $d <= \Carbon\Carbon::create($year, $month)->daysInMonth; $d++)
                                    @php
                                        $dateStr = \Carbon\Carbon::create($year, $month, $d)->format('Y-m-d');
                                        $status = null;
                                        if (isset($attendances[$student->id])) {
                                            $record = $attendances[$student->id]->firstWhere('date', $dateStr); // Not efficient but simple
                                            if ($record)
                                                $status = $record->status;
                                        }
                                        if ($status == 'present')
                                            $presentCount++;
                                    @endphp
                                    <td class="px-1 py-3 text-center">
                                        @if($status == 'present')
                                            <span class="text-green-500 font-bold">P</span>
                                        @elseif($status == 'absent')
                                            <span class="text-red-500 font-bold">A</span>
                                        @elseif($status == 'late')
                                            <span class="text-yellow-600 font-bold">L</span>
                                        @elseif($status == 'excused')
                                            <span class="text-blue-400 font-bold">E</span>
                                        @else
                                            <span class="text-gray-200">-</span>
                                        @endif
                                    </td>
                                @endfor
                                <td class="px-4 py-3 text-center font-bold text-gray-800 bg-gray-50">
                                    {{ $presentCount }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-master-layout>