<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Class Timetable</h1>
                @if(isset($classRoom))
                    <p class="text-gray-500">Class: <span class="font-semibold">{{ $classRoom->name }}
                            ({{ $classRoom->section }})</span></p>
                @endif
            </div>
            <div class="flex gap-2">
                <button
                    class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg font-semibold transition shadow-sm"
                    onclick="window.print()">
                    <i class="fas fa-print mr-1"></i> Print
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="p-4 border border-gray-700 w-24">Day / Time</th>
                            @foreach($periods as $period)
                                <th class="p-4 border border-gray-700 min-w-[150px]">
                                    <div class="font-bold">{{ $period->name }}</div>
                                    <div class="text-xs text-blue-200 mt-1">
                                        {{ \Carbon\Carbon::parse($period->start_time)->format('h:i A') }} -
                                        {{ \Carbon\Carbon::parse($period->end_time)->format('h:i A') }}
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($days as $day)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4 border border-gray-200 font-bold text-gray-700 bg-gray-50">{{ $day }}</td>
                                @foreach($periods as $period)
                                    @php
                                        $entry = $timetable[$day][$period->id] ?? null;
                                    @endphp
                                    <td class="p-2 border border-gray-200 h-24 align-top">
                                        @if($entry)
                                            <div
                                                class="bg-green-50 border-l-4 border-green-500 p-2 rounded h-full hover:bg-green-100 transition ">
                                                <div class="font-bold text-green-800 text-sm mb-1">
                                                    {{ $entry->subject->name }}
                                                </div>
                                                <div class="text-gray-600 text-xs flex items-center mb-1">
                                                    <i class="fas fa-chalkboard-teacher mr-1 text-gray-400"></i>
                                                    {{ $entry->teacher->name ?? 'N/A' }}
                                                </div>
                                                <div class="text-gray-400 text-[10px]">
                                                    {{ $entry->subject->code }}
                                                </div>
                                            </div>
                                        @else
                                            <div class="h-full flex items-center justify-center text-gray-300 text-xs">
                                                -
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Print Styles --}}
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #sidebar,
            header {
                display: none;
            }

            .fade-in {
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .fade-in * {
                visibility: visible;
            }

            button {
                display: none;
            }
        }
    </style>
</x-master-layout>