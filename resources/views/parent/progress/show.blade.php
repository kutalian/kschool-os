<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
             <div>
                <a href="{{ route('parent.children.index') }}"
                    class="text-gray-500 hover:text-blue-600 transition mb-2 inline-block">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Children
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Progress Report: {{ $student->first_name }} {{ $student->last_name }}</h1>
            </div>
            <div class="flex gap-2">
                 <button
                    class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg font-semibold transition shadow-sm"
                    onclick="window.print()">
                    <i class="fas fa-print mr-1"></i> Print Report
                </button>
            </div>
        </div>

        @if($exams->isEmpty())
             <div class="bg-white rounded-xl shadow-sm p-8 text-center border border-gray-100">
                <div class="text-gray-300 mb-4">
                    <i class="fas fa-clipboard-list text-6xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">No Exams Found</h3>
                <p class="text-gray-500">No exams have been scheduled for this class yet.</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach($exams as $exam)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden break-inside-avoid">
                        <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">{{ $exam->name }}</h3>
                                <div class="text-sm text-gray-500">
                                    <span class="mr-3"><i class="fas fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($exam->start_date)->format('M d, Y') }}</span>
                                    <span><i class="fas fa-tag mr-1"></i> {{ ucfirst($exam->exam_type) }}</span>
                                </div>
                            </div>
                           <div>
                                @if($exam->is_published)
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Results Out</span>
                                @else
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Scheduled</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-0">
                            @if(isset($marks[$exam->id]) && $marks[$exam->id]->count() > 0)
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-white border-b border-gray-100">
                                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Subject</th>
                                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Marks</th>
                                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Total</th>
                                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Grade</th>
                                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Result</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @php 
                                            $totalObtained = 0;
                                            $totalMax = 0;
                                        @endphp
                                        @foreach($marks[$exam->id] as $mark)
                                             @php 
                                                $totalObtained += $mark->marks_obtained;
                                                $totalMax += $mark->total_marks ?? 100;
                                                $percentage = ($mark->total_marks > 0) ? ($mark->marks_obtained / $mark->total_marks) * 100 : 0;
                                                $isPass = $percentage >= 35; 
                                            @endphp
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="px-6 py-3 font-medium text-gray-900">
                                                    {{ $mark->subject->name }}
                                                </td>
                                                <td class="px-6 py-3 text-right font-bold text-gray-800">{{ $mark->marks_obtained }}</td>
                                                <td class="px-6 py-3 text-right text-gray-500">{{ $mark->total_marks ?? 100 }}</td>
                                                <td class="px-6 py-3 text-center">
                                                    @if($percentage >= 90) A+
                                                    @elseif($percentage >= 80) A
                                                    @elseif($percentage >= 70) B
                                                    @elseif($percentage >= 60) C
                                                    @elseif($percentage >= 50) D
                                                    @else F
                                                    @endif
                                                </td>
                                                <td class="px-6 py-3 text-center">
                                                    @if($isPass)
                                                        <span class="text-green-600 font-bold text-xs">PASS</span>
                                                    @else
                                                        <span class="text-red-600 font-bold text-xs">FAIL</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                         <tr class="bg-gray-50 font-bold border-t border-gray-200">
                                            <td class="px-6 py-3 text-gray-800">TOTAL</td>
                                            <td class="px-6 py-3 text-right text-indigo-700">{{ $totalObtained }}</td>
                                            <td class="px-6 py-3 text-right text-gray-600">{{ $totalMax }}</td>
                                            <td class="px-6 py-3 text-center text-indigo-700">
                                                {{ $totalMax > 0 ? number_format(($totalObtained / $totalMax) * 100, 2) . '%' : '-' }}
                                            </td>
                                            <td class="px-6 py-3"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <div class="p-8 text-center text-gray-500">
                                    <p class="italic">Detailed results not yet available or published.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
     {{-- Print Styles --}}
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #sidebar, header {
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
