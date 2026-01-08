<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card - {{ $student->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-gray-100 p-8">

    <div class="max-w-[210mm] mx-auto bg-white p-8 shadow-lg min-h-[297mm]">
        <!-- Header -->
        <div class="text-center border-b-2 border-gray-800 pb-6 mb-6">
            <h1 class="text-3xl font-bold uppercase tracking-wide text-gray-900">School Name ERP</h1>
            <p class="text-gray-600 mt-1">123 Education Street, Knowledge City</p>
            <p class="text-gray-600">Tel: +123 456 7890 | Email: info@school.com</p>
            <h2 class="text-xl font-bold mt-4 uppercase bg-gray-800 text-white inline-block px-4 py-1 rounded">Student
                Report Card</h2>
        </div>

        <!-- Student Details -->
        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <table class="w-full text-sm">
                    <tr>
                        <td class="font-bold py-1 w-32">Student Name:</td>
                        <td class="py-1 border-b border-gray-300">{{ $student->name }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1">Admission No:</td>
                        <td class="py-1 border-b border-gray-300">{{ $student->admission_no }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1">Class:</td>
                        <td class="py-1 border-b border-gray-300">{{ $student->class_room->name }} -
                            {{ $student->class_room->section }}</td>
                    </tr>
                </table>
            </div>
            <div>
                <table class="w-full text-sm">
                    <tr>
                        <td class="font-bold py-1 w-32">Exam:</td>
                        <td class="py-1 border-b border-gray-300">{{ $exam->name }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1">Academic Year:</td>
                        <td class="py-1 border-b border-gray-300">{{ $exam->academic_year }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1">Date:</td>
                        <td class="py-1 border-b border-gray-300">{{ date('d M, Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Marks Table -->
        <div class="mb-8">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left">Subject</th>
                        <th class="border border-gray-300 px-4 py-2 text-center w-24">Grade</th>
                        <th class="border border-gray-300 px-4 py-2 text-right w-32">Marks Obtained</th>
                        <th class="border border-gray-300 px-4 py-2 text-right w-32">Max Marks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($marks as $mark)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $mark->subject->name }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <!-- Simple Grade Calculation for Subject -->
                                @php
                                    $subjPerc = ($mark->marks_obtained / 100) * 100;
                                    $subjGrade = $subjPerc >= 75 ? 'A' : ($subjPerc >= 60 ? 'B' : ($subjPerc >= 50 ? 'C' : 'D'));
                                @endphp
                                {{ $subjGrade }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-right">{{ $mark->marks_obtained }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">100</td>
                        </tr>
                    @endforeach
                    <tr class="font-bold bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2 text-right" colspan="2">TOTAL</td>
                        <td class="border border-gray-300 px-4 py-2 text-right">{{ $totalMarksObtained }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-right">{{ $totalMaxMarks }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Performance Summary -->
        <div class="grid grid-cols-2 gap-8 mb-12">
            <div class="border border-gray-300 p-4 rounded bg-gray-50">
                <h3 class="font-bold text-gray-800 mb-3 border-b border-gray-300 pb-1">Academic Performance</h3>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Percentage:</span>
                    <span class="font-bold">{{ number_format($percentage, 2) }}%</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Overall Grade:</span>
                    <span class="font-bold text-blue-600">{{ $grade }}</span>
                </div>
            </div>
            <div class="border border-gray-300 p-4 rounded bg-gray-50">
                <h3 class="font-bold text-gray-800 mb-3 border-b border-gray-300 pb-1">Attendance Summary</h3>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Total Working Days:</span>
                    <span class="font-bold">{{ $totalAttendance }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Days Present:</span>
                    <span class="font-bold">{{ $presentDays }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Percentage:</span>
                    <span class="font-bold">{{ number_format($attendancePercentage, 1) }}%</span>
                </div>
            </div>
        </div>

        <!-- Remarks -->
        <div class="mb-16">
            <label class="font-bold text-gray-800 block mb-1">Class Teacher's Remarks:</label>
            <div class="border-b border-gray-400 h-8"></div>
        </div>

        <!-- Signatures -->
        <div class="flex justify-between items-end mt-20">
            <div class="text-center">
                <div class="border-t border-gray-400 w-40 mb-2"></div>
                <p class="font-bold text-sm text-gray-600">Class Teacher</p>
            </div>
            <div class="text-center">
                <div class="border-t border-gray-400 w-40 mb-2"></div>
                <p class="font-bold text-sm text-gray-600">Principal</p>
            </div>
            <div class="text-center">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ url()->current() }}"
                    alt="QR Code" class="w-24 h-24 mb-2 opacity-80">
                <p class="text-xs text-gray-400">Scan to Verify</p>
            </div>
        </div>
    </div>

    <!-- Print Button -->
    <div class="fixed bottom-8 right-8 no-print">
        <button onclick="window.print()"
            class="bg-blue-600 text-white px-6 py-3 rounded-full shadow-lg hover:bg-blue-700 transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z"
                    clip-rule="evenodd" />
            </svg>
            Print Report
        </button>
    </div>

</body>

</html>