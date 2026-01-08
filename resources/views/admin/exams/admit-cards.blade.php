<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admit Cards - {{ $exam->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none;
            }

            .page-break {
                page-break-after: always;
            }

            body {
                background: white;
            }

            .card {
                border: 2px solid #000;
                page-break-inside: avoid;
            }
        }

        .card {
            border: 2px solid #e5e7eb;
        }
    </style>
</head>

<body class="bg-gray-100 p-8">

    <div class="max-w-4xl mx-auto no-print mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Admit Cards: {{ $exam->name }}</h1>
            <p class="text-gray-500">Class: {{ $exam->class_room->name }} {{ $exam->class_room->section }} | Total
                Students: {{ $students->count() }}</p>
        </div>
        <button onclick="window.print()"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">
            <i class="fas fa-print mr-2"></i> Print Admit Cards
        </button>
    </div>

    <div class="max-w-4xl mx-auto space-y-8">
        @forelse($students as $student)
            <div class="card bg-white p-8 rounded-xl relative page-break">
                <!-- Header -->
                <div class="text-center border-b-2 border-gray-100 pb-4 mb-6">
                    <h2 class="text-2xl font-bold text-blue-900 uppercase tracking-wide">School ERP High School</h2>
                    <p class="text-gray-500 text-sm">123 Education Lane, Academic City, State</p>
                    <h3
                        class="mt-2 text-xl font-bold text-gray-800 uppercase border-2 border-gray-800 inline-block px-4 py-1 rounded">
                        Admit Card</h3>
                </div>

                <div class="flex gap-8">
                    <!-- Photo -->
                    <div
                        class="w-32 h-40 bg-gray-100 border border-gray-300 flex items-center justify-center text-gray-400">
                        @if($student->profile_pic)
                            <img src="{{ asset('storage/' . $student->profile_pic) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-xs text-center p-2">Paste Photo Here</span>
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="flex-1 grid grid-cols-2 gap-y-4 text-sm">
                        <div>
                            <span class="block text-gray-500 text-xs uppercase tracking-wider">Student Name</span>
                            <span class="font-bold text-lg text-gray-800">{{ $student->first_name }}
                                {{ $student->last_name }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-xs uppercase tracking-wider">Admission No</span>
                            <span class="font-bold text-lg text-gray-800">{{ $student->admission_no }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-xs uppercase tracking-wider">Class & Section</span>
                            <span class="font-bold text-lg text-gray-800">{{ $student->classRoom->name }}
                                {{ $student->classRoom->section }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-xs uppercase tracking-wider">Roll Number</span>
                            <span class="font-bold text-lg text-gray-800">{{ $student->roll_no ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-xs uppercase tracking-wider">Exam Name</span>
                            <span class="font-bold text-lg text-gray-800">{{ $exam->name }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-xs uppercase tracking-wider">Academic Session</span>
                            <span class="font-bold text-lg text-gray-800">{{ $exam->academic_year ?? date('Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Footer / Signatures -->
                <div class="mt-8 pt-8 border-t border-gray-100 flex justify-between items-end">
                    <div class="text-center w-40">
                        <div class="border-b border-gray-400 mb-2"></div>
                        <p class="text-xs text-gray-500 uppercase">Student Signature</p>
                    </div>
                    <div class="text-center w-40">
                        <div class="border-b border-gray-400 mb-2"></div>
                        <p class="text-xs text-gray-500 uppercase">Principal Signature</p>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="mt-6 bg-gray-50 p-4 rounded text-xs text-gray-600">
                    <p class="font-bold mb-1">Instructions:</p>
                    <ul class="list-disc pl-4 space-y-1">
                        <li>Candidate must bring this Admit Card to the examination hall.</li>
                        <li>Report at least 15 minutes before the scheduled time.</li>
                        <li>Electronic devices are strictly prohibited inside the exam hall.</li>
                    </ul>
                </div>
            </div>
        @empty
            <div class="text-center py-12 text-gray-500">
                No active students found in this class.
            </div>
        @endforelse
    </div>

</body>

</html>