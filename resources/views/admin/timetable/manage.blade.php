<x-master-layout>
    <div class="max-w-[98%] mx-auto py-6">
        
        <!-- Header / Class Selector -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Weekly Schedule</h1>
                <p class="text-gray-500">Managing timetable for <span class="font-bold text-blue-600">{{ $classRoom->name }} {{ $classRoom->section }}</span></p>
            </div>
            <div class="flex gap-3">
                 <button onclick="openAddDayModal()" class="flex items-center gap-2 bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition font-medium shadow-sm">
                    <i class="fas fa-plus text-blue-500"></i> Add Day
                </button>
                <button onclick="openAddPeriodModal()" class="flex items-center gap-2 bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition font-medium shadow-sm">
                    <i class="fas fa-plus text-indigo-500"></i> Add Period
                </button>
                <form action="{{ route('timetable.store') }}" method="POST" id="saveForm" class="hidden">
                    @csrf
                </form>
                <a href="{{ route('timetable.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center bg-gray-100 px-3 py-2 rounded-lg">
                    <i class="fas fa-arrow-left mr-2"></i> Back
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

        <!-- Timetable Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-900 text-white text-xs font-bold uppercase tracking-wider text-center">
                            <th class="p-4 w-32 border-r border-slate-700 sticky left-0 bg-slate-900 z-10">Day / Time</th>
                            @foreach($periods as $period)
                                <th class="p-3 min-w-[140px] border-r border-slate-700 last:border-0 group relative text-center">
                                    <div class="flex flex-col items-center justify-center px-2">
                                        <div class="flex items-center justify-center gap-2 mb-1 w-full">
                                            <span class="text-blue-300 text-sm font-bold">{{ $period->name ?? 'Period' }}</span>
                                            <button onclick="openDeleteStructureModal('period', {{ $period->id }})" 
                                                class="text-slate-500 hover:text-red-400 transition" title="Delete Period">
                                                <i class="fas fa-trash-alt text-[10px]"></i>
                                            </button>
                                        </div>
                                        <span class="text-xs text-slate-400 font-mono">{{ \Carbon\Carbon::parse($period->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($period->end_time)->format('H:i') }}</span>
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
                        @foreach($days as $day)
                            <tr class="hover:bg-gray-50 transition group">
                                <!-- Day Column -->
                                <td class="p-4 font-bold text-gray-700 border-r border-gray-200 bg-gray-50 sticky left-0 z-10 text-center group/date min-w-[120px]">
                                    <div class="flex flex-col items-center justify-center">
                                         <div class="flex items-center justify-center gap-2 w-full">
                                            <div class="text-lg">{{ $day->name }}</div>
                                            <button onclick="openDeleteStructureModal('day', {{ $day->id }})" 
                                                class="text-gray-300 hover:text-red-500 transition" title="Delete Day">
                                                <i class="fas fa-trash-alt text-[10px]"></i>
                                            </button>
                                         </div>
                                    </div>
                                </td>

                                @foreach($periods as $period)
                                    @php
                                        $entry = $schedule[$day->name][$period->id] ?? null;
                                        // Note: Logic assumes Timetable uses 'day' string matching name.
                                    @endphp
                                    <td class="p-0 border-r border-gray-200 relative group/cell hover:bg-white transition-colors h-24 min-w-[140px]">
                                        
                                        @if($entry)
                                            <div class="absolute inset-0 flex flex-col items-center justify-center p-2 bg-indigo-50/50">
                                                <div class="font-bold text-indigo-700 text-sm">{{ $entry->subject->name ?? 'Subject' }}</div>
                                                <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                                    <i class="fas fa-user-tie text-[10px]"></i> {{ $entry->teacher->username ?? 'No Teacher' }}
                                                </div>
                                                
                                                <button onclick="clearSlot('{{ $day->name }}', {{ $period->id }})" 
                                                    class="absolute top-1 right-1 text-gray-300 hover:text-red-500 opacity-0 group-hover/cell:opacity-100 transition p-1">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @else
                                            <button onclick="openAssignModal('{{ $day->name }}', {{ $period->id }})"
                                                class="absolute inset-0 w-full h-full flex items-center justify-center text-slate-200 hover:text-blue-500 hover:bg-blue-50/30 transition group/btn">
                                                <div class="w-8 h-8 rounded-full bg-slate-50 group-hover/btn:bg-white shadow-sm flex items-center justify-center border border-slate-100 group-hover/btn:border-blue-200 transition">
                                                    <i class="fas fa-plus text-sm group-hover/btn:scale-110 transition-transform"></i>
                                                </div>
                                            </button>
                                        @endif
                                    </td>
                                @endforeach
                                
                                @if($periods->isEmpty())
                                    <td class="p-4 text-center text-gray-400 text-sm">Add periods to start scheduling</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($days->isEmpty())
                    <div class="p-12 text-center">
                        <div class="inline-block p-4 rounded-full bg-blue-50 mb-4">
                            <i class="fas fa-calendar-week text-3xl text-blue-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Setup Weekly Schedule</h3>
                        <p class="text-gray-500 mb-6">Start by adding days (e.g., Monday) and periods.</p>
                        <button onclick="openAddDayModal()" class="text-blue-600 font-medium hover:underline">Add First Day</button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add Day Modal -->
    <div id="addDayModal" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 hidden transition-opacity opacity-0">
        <div class="bg-white rounded-xl shadow-xl w-96 transform scale-95 transition-transform" id="addDayModalContent">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Add School Day</h3>
                    <button onclick="closeAddDayModal()" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
                </div>
                <form action="{{ route('timetable.day.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $classRoom->id }}">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Day Name</label>
                        <select name="name" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>
                    <button type="submit" style="background-color: #4f46e5; color: #ffffff;" class="w-full py-2.5 rounded-lg hover:opacity-90 transition font-medium">Add Day</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Period Modal -->
    <div id="addPeriodModal" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 hidden transition-opacity opacity-0">
        <div class="bg-white rounded-xl shadow-xl w-96 transform scale-95 transition-transform" id="addPeriodModalContent">
            <div class="p-6">
                 <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Add Period</h3>
                    <button onclick="closeAddPeriodModal()" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
                </div>
                <form action="{{ route('timetable.period.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $classRoom->id }}">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name (Optional)</label>
                        <input type="text" name="name" placeholder="Period 1" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                     <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                            <input type="time" name="start_time" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                             <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                            <input type="time" name="end_time" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    <button type="submit" style="background-color: #4f46e5; color: #ffffff;" class="w-full py-2.5 rounded-lg hover:opacity-90 transition font-medium">Add Period</button>
                </form>
            </div>
        </div>
    </div>


    <!-- Assign Modal -->
    <div id="assignModal" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 hidden transition-opacity opacity-0">
        <div class="bg-white rounded-xl shadow-xl w-96 transform scale-95 transition-transform" id="assignModalContent">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Assign Subject</h3>
                    <button onclick="closeAssignModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <select id="modalSubject" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select Subject...</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                         <label class="block text-sm font-medium text-gray-700 mb-1">Teacher (Optional)</label>
                         <select id="modalTeacher" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select Teacher...</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->username }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button onclick="submitAssignment()" style="background-color: #4f46e5; color: #ffffff;" class="w-full py-2.5 rounded-lg hover:opacity-90 transition font-medium shadow-md">
                        Assign Subject
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Structure Modal -->
    <div id="deleteStructureModal" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 hidden transition-opacity opacity-0">
        <div class="bg-white rounded-lg shadow-xl w-96 transform scale-95 transition-transform" id="deleteStructureModalContent">
            <div class="p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-trash-alt text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Confirm Delete</h3>
                <p class="text-sm text-gray-500 mb-6">Are you sure you want to delete this? This action cannot be undone.</p>
                <form id="deleteStructureForm" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="deleteStructureId">
                    <div class="flex justify-center space-x-3">
                        <button type="button" onclick="closeDeleteStructureModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

     <!-- Confirmation Modal (Clear Slot) -->
     <div id="clearModal" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 hidden transition-opacity opacity-0">
        <div class="bg-white rounded-lg shadow-xl w-96 transform scale-95 transition-transform" id="clearModalContent">
            <div class="p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Clear Slot?</h3>
                <p class="text-sm text-gray-500 mb-6">Are you sure you want to remove this assignment? This action cannot be undone.</p>
                <div class="flex justify-center space-x-3">
                    <button onclick="closeClearModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">Cancel</button>
                    <button id="confirmClearBtn" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">Yes, Clear it</button>
                </div>
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
        
        const addDayModal = document.getElementById('addDayModal');
        const addDayModalContent = document.getElementById('addDayModalContent');
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

        // Delete Structure (Day/Period)
        function openDeleteStructureModal(type, id) {
            deleteStructureId.value = id;
            if (type === 'day') {
                deleteStructureForm.action = '{{ route('timetable.day.destroy') }}';
            } else {
                deleteStructureForm.action = '{{ route('timetable.period.destroy') }}';
            }
            openModal(deleteStructureModal, deleteStructureModalContent);
        }

        function closeDeleteStructureModal() {
            closeModal(deleteStructureModal, deleteStructureModalContent);
        }

        // Add Day
        function openAddDayModal() { openModal(addDayModal, addDayModalContent); }
        function closeAddDayModal() { closeModal(addDayModal, addDayModalContent); }

        // Add Period
        function openAddPeriodModal() { openModal(addPeriodModal, addPeriodModalContent); }
        function closeAddPeriodModal() { closeModal(addPeriodModal, addPeriodModalContent); }

        // Assign
        function openAssignModal(day, periodId) {
            currentSlot = { day, periodId };
            document.getElementById('modalSubject').value = '';
            document.getElementById('modalTeacher').value = '';
            openModal(assignModal, assignModalContent);
        }
        function closeAssignModal() { 
            currentSlot = null;
            closeModal(assignModal, assignModalContent); 
        }

        function submitAssignment() {
            const subjectId = document.getElementById('modalSubject').value;
            const teacherId = document.getElementById('modalTeacher').value;

            if (!subjectId || !currentSlot) return;

             fetch('{{ route('timetable.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    class_id: {{ $classRoom->id }},
                    day: currentSlot.day,
                    period_id: currentSlot.periodId,
                    subject_id: subjectId,
                    teacher_id: teacherId
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    location.reload(); 
                } else {
                     alert(data.message || 'Error saving');
                }
            });
        }

        // Clear Slot
        function clearSlot(day, periodId) {
            slotToDelete = { day, periodId };
            openModal(clearModal, clearModalContent);
        }
        function closeClearModal() {
            slotToDelete = null;
            closeModal(clearModal, clearModalContent);
        }

        confirmClearBtn.addEventListener('click', function() {
             if(!slotToDelete) return;

            fetch('{{ route('timetable.destroy') }}', {
                 method: 'POST',
                 headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                     class_id: {{ $classRoom->id }},
                     day: slotToDelete.day,
                    period_id: slotToDelete.periodId,
                })
            }).then(res => {
                 if(res.ok) location.reload();
            });
        });

        // Close on background click
        [assignModal, clearModal, addDayModal, addPeriodModal, deleteStructureModal].forEach(modal => {
            modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(modal, modal.firstElementChild); });
        });

    </script>
</x-master-layout>