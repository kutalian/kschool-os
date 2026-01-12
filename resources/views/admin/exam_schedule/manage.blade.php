<x-master-layout>
    <div class="max-w-[98%] mx-auto py-8">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Exam Timetable</h1>
                <p class="text-gray-500 mt-1">
                    Exam: <span class="font-bold text-indigo-600">{{ $exam->name }}</span> |
                    Class: <span class="font-bold text-indigo-600">{{ $classRoom->name }}
                        {{ $classRoom->section }}</span>
                </p>
            </div>
            <div class="flex gap-2">
                <button onclick="openAddPeriodModal()"
                    class="text-sm bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-2 rounded-lg border border-indigo-200 transition font-medium">
                    <i class="fas fa-plus mr-1"></i> Add Period
                </button>
                <button onclick="openAddDateModal()"
                    class="text-sm bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-2 rounded-lg border border-indigo-200 transition font-medium">
                    <i class="fas fa-calendar-plus mr-1"></i> Add Date
                </button>
                <a href="{{ route('timetable.index', ['tab' => 'exam']) }}"
                    class="text-sm text-gray-500 hover:text-gray-700 bg-gray-50 px-3 py-2 rounded-lg border border-gray-200 transition">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <span onclick="this.parentElement.style.display='none'"
                    class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                    <i class="fas fa-times text-green-500"></i>
                </span>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-900 text-white text-xs font-bold uppercase tracking-wider text-center">
                            <th class="p-4 w-32 border-r border-slate-700 sticky left-0 bg-slate-900 z-10">Date / Time
                            </th>
                            @foreach($periods as $period)
                                <th
                                    class="p-3 min-w-[140px] border-r border-slate-700 last:border-0 group relative text-center">
                                    <div class="flex flex-col items-center justify-center px-2">
                                        <div class="flex items-center justify-center gap-2 mb-1 w-full">
                                            <span
                                                class="text-blue-300 text-sm font-bold">{{ $period->name ?? 'Period' }}</span>
                                            <button onclick="openDeleteStructureModal('period', {{ $period->id }})"
                                                class="text-slate-500 hover:text-red-400 transition" title="Delete Period">
                                                <i class="fas fa-trash-alt text-[10px]"></i>
                                            </button>
                                        </div>
                                        <span
                                            class="text-xs text-slate-400 font-mono">{{ \Carbon\Carbon::parse($period->start_time)->format('H:i') }}
                                            - {{ \Carbon\Carbon::parse($period->end_time)->format('H:i') }}</span>
                                    </div>
                                </th>
                            @endforeach
                            <!-- Empty Header for spacing if no periods -->
                            @if($periods->isEmpty())
                                <th class="p-4 text-gray-500 italic font-normal">No Periods Added</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($dates as $dateModel)
                            <tr class="hover:bg-gray-50 transition group">
                                <!-- Date Column -->
                                <td
                                    class="p-4 font-bold text-gray-700 border-r border-gray-200 bg-gray-50 sticky left-0 z-10 text-center group/date min-w-[120px]">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="flex items-center justify-center gap-2 w-full">
                                            <div class="text-lg">{{ \Carbon\Carbon::parse($dateModel->date)->format('l') }}
                                            </div>
                                            <button onclick="openDeleteStructureModal('date', {{ $dateModel->id }})"
                                                class="text-gray-300 hover:text-red-500 transition" title="Delete Date">
                                                <i class="fas fa-trash-alt text-[10px]"></i>
                                            </button>
                                        </div>
                                        <div class="text-xs text-gray-400 font-normal mt-1">
                                            {{ \Carbon\Carbon::parse($dateModel->date)->format('M d, Y') }}</div>
                                    </div>
                                </td>

                                @foreach($periods as $period)
                                    <td class="p-2 border-r border-gray-100 relative h-24 align-top w-[140px]">
                                        @php
                                            // Ensure time format matches standard H:i:s or close enough match
                                            // The controller keys by 'H:i:s' usually.
                                            $key = $period->start_time;
                                            $entry = $schedule[$dateModel->date][$key] ?? null;
                                        @endphp

                                        @if($entry)
                                            <div
                                                class="h-full w-full bg-white rounded-lg border border-gray-200 p-2 shadow-sm hover:shadow-md transition flex flex-col items-center justify-center text-center relative group-hover/slot:border-indigo-200">
                                                <div
                                                    class="text-xs font-bold text-indigo-600 mb-1 overflow-hidden w-full whitespace-nowrap text-ellipsis">
                                                    {{ $entry->subject->name }}
                                                </div>
                                                @if($entry->room_number)
                                                    <div class="text-[10px] text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded">Rm:
                                                        {{ $entry->room_number }}
                                                    </div>
                                                @endif

                                                <button onclick="clearSlot('{{ $dateModel->date }}', {{ $period->id }})"
                                                    class="absolute top-0 right-0 m-1 w-5 h-5 flex items-center justify-center text-gray-300 hover:text-red-600 hover:bg-red-50 rounded-full transition z-20"
                                                    title="Delete Assignment">
                                                    <i class="fas fa-times text-[10px]"></i>
                                                </button>
                                            </div>
                                        @else
                                            <div class="h-full w-full flex items-center justify-center transition duration-300">
                                                <button onclick="openAssignModal('{{ $dateModel->date }}', {{ $period->id }})"
                                                    class="w-8 h-8 rounded-full bg-gray-50 text-gray-300 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition shadow-sm transform hover:scale-110">
                                                    <i class="fas fa-plus text-sm"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach

                        @if($dates->isEmpty())
                            <tr>
                                <td colspan="{{ $periods->count() + 1 }}" class="p-8 text-center text-gray-500">
                                    No dates added. Click "Add Date" to start building your schedule.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Date Modal -->
    <div id="addDateModal"
        class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 hidden transition-opacity opacity-0">
        <div class="bg-white rounded-xl shadow-xl w-96 transform scale-95 transition-transform"
            id="addDateModalContent">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Add Date</h3>
                    <button onclick="closeAddDateModal()" class="text-gray-400 hover:text-gray-600"><i
                            class="fas fa-times"></i></button>
                </div>
                <form action="{{ route('exam-schedule.date.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" name="date" required
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <button type="submit" style="background-color: #4f46e5; color: #ffffff;"
                        class="w-full py-2.5 rounded-lg hover:opacity-90 transition font-medium">Add Date</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Period Modal -->
    <div id="addPeriodModal"
        class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 hidden transition-opacity opacity-0">
        <div class="bg-white rounded-xl shadow-xl w-96 transform scale-95 transition-transform"
            id="addPeriodModalContent">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Add Period</h3>
                    <button onclick="closeAddPeriodModal()" class="text-gray-400 hover:text-gray-600"><i
                            class="fas fa-times"></i></button>
                </div>
                <form action="{{ route('exam-schedule.period.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name (Optional)</label>
                        <input type="text" name="name" placeholder="Period 1"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                            <input type="time" name="start_time" required
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                            <input type="time" name="end_time" required
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    <button type="submit" style="background-color: #4f46e5; color: #ffffff;"
                        class="w-full py-2.5 rounded-lg hover:opacity-90 transition font-medium">Add Period</button>
                </form>
            </div>
        </div>
    </div>


    <!-- Assign Modal -->
    <div id="assignModal"
        class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 hidden transition-opacity opacity-0">
        <div class="bg-white rounded-xl shadow-xl w-96 transform scale-95 transition-transform" id="assignModalContent">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Assign Exam</h3>
                    <button onclick="closeAssignModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <select id="modalSubject"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select Subject...</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Room Number</label>
                        <input type="text" id="modalRoom" placeholder="e.g. 101"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <button onclick="submitAssignment()" style="background-color: #4f46e5; color: #ffffff;"
                        class="w-full py-2.5 rounded-lg hover:opacity-90 transition font-medium shadow-md">
                        Assign Exam
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Structure Modal -->
    <div id="deleteStructureModal"
        class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 hidden transition-opacity opacity-0">
        <div class="bg-white rounded-lg shadow-xl w-96 transform scale-95 transition-transform"
            id="deleteStructureModalContent">
            <div class="p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-trash-alt text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Confirm Delete</h3>
                <p class="text-sm text-gray-500 mb-6">Are you sure you want to delete this? This action cannot be
                    undone.</p>
                <form id="deleteStructureForm" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="deleteStructureId">
                    <div class="flex justify-center space-x-3">
                        <button type="button" onclick="closeDeleteStructureModal()"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentSlot = null;
        let slotToDelete = null;

        const assignModal = document.getElementById('assignModal');
        const assignModalContent = document.getElementById('assignModalContent');
        const clearModal = document.getElementById('clearModal');
        const clearModalContent = document.getElementById('clearModalContent');
        const confirmClearBtn = document.getElementById('confirmClearBtn');

        const addDateModal = document.getElementById('addDateModal');
        const addDateModalContent = document.getElementById('addDateModalContent');
        const addPeriodModal = document.getElementById('addPeriodModal');
        const addPeriodModalContent = document.getElementById('addPeriodModalContent');

        const deleteStructureModal = document.getElementById('deleteStructureModal');
        const deleteStructureModalContent = document.getElementById('deleteStructureModalContent');
        const deleteStructureForm = document.getElementById('deleteStructureForm');
        const deleteStructureId = document.getElementById('deleteStructureId');

        function openModal(modal, content) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);
        }

        function closeModal(modal, content) {
            modal.classList.add('opacity-0');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }

        // Delete Structure (Date/Period)
        function openDeleteStructureModal(type, id) {
            deleteStructureId.value = id;
            if (type === 'date') {
                deleteStructureForm.action = '{{ route('exam-schedule.date.destroy') }}';
            } else {
                deleteStructureForm.action = '{{ route('exam-schedule.period.destroy') }}';
            }
            openModal(deleteStructureModal, deleteStructureModalContent);
        }

        function closeDeleteStructureModal() {
            closeModal(deleteStructureModal, deleteStructureModalContent);
        }

        // Add Date
        function openAddDateModal() { openModal(addDateModal, addDateModalContent); }
        function closeAddDateModal() { closeModal(addDateModal, addDateModalContent); }

        // Add Period
        function openAddPeriodModal() { openModal(addPeriodModal, addPeriodModalContent); }
        function closeAddPeriodModal() { closeModal(addPeriodModal, addPeriodModalContent); }

        // Assign
        function openAssignModal(date, periodId) {
            currentSlot = { date, periodId };
            document.getElementById('modalSubject').value = '';
            document.getElementById('modalRoom').value = '';
            openModal(assignModal, assignModalContent);
        }
        function closeAssignModal() {
            currentSlot = null;
            closeModal(assignModal, assignModalContent);
        }

        function submitAssignment() {
            const subjectId = document.getElementById('modalSubject').value;
            const roomNumber = document.getElementById('modalRoom').value;

            if (!subjectId || !currentSlot) return;

            fetch('{{ route('exam-schedule.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    exam_id: {{ $exam->id }},
                    class_id: {{ $classRoom->id }},
                    date: currentSlot.date,
                    period_id: currentSlot.periodId,
                    subject_id: subjectId,
                    room_number: roomNumber
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Error saving');
                    }
                });
        }

        // Clear Slot
        function clearSlot(date, periodId) {
            slotToDelete = { date, periodId };
            openModal(clearModal, clearModalContent);
        }
        function closeClearModal() {
            slotToDelete = null;
            closeModal(clearModal, clearModalContent);
        }

        confirmClearBtn.addEventListener('click', function () {
            if (!slotToDelete) return;

            fetch('{{ route('exam-schedule.destroy') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    exam_id: {{ $exam->id }},
                    class_id: {{ $classRoom->id }},
                    date: slotToDelete.date,
                    period_id: slotToDelete.periodId,
                })
            }).then(res => {
                if (res.ok) location.reload();
            });
        });

        // Close on background click
        [assignModal, clearModal, addDateModal, addPeriodModal, deleteStructureModal].forEach(modal => {
            modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(modal, modal.firstElementChild); });
        });

    </script>
</x-master-layout>