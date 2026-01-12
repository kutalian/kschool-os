<x-master-layout>
    <div class="max-w-6xl mx-auto" x-data="{
        showConfirmModal: false,
        selectedCount: {{ count($students) }}, 
        sourceClass: '{{ $classRooms->find(request('source_class_id'))->name ?? '' }} {{ $classRooms->find(request('source_class_id'))->section ?? '' }}',
        destinationClass: '',
        
        updateDestination() {
            let select = document.getElementById('destination_select');
            this.destinationClass = select.options[select.selectedIndex].text;
        },

        openModal() {
            let select = document.getElementById('destination_select');
            if(!select.value) {
                alert('Please select a destination class');
                return;
            }
            
            this.updateDestination();
            
            // Recalculate selected count based on checkboxes
            let checkboxes = document.querySelectorAll('.student-checkbox:checked');
            this.selectedCount = checkboxes.length;

            if(this.selectedCount === 0) {
                alert('Please select at least one student to promote');
                return;
            }

            this.showConfirmModal = true;
        },
        
        submitForm() {
            document.getElementById('promotion-form').submit();
        }
    }">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Promote Students</h1>
            <a href="{{ route('students.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Students
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <form action="{{ route('students.promotion') }}" method="GET" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Select Source Class (From)</label>
                    <select name="source_class_id" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                        <option value="">-- Select Class --</option>
                        @foreach($classRooms as $class)
                            <option value="{{ $class->id }}" {{ request('source_class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} {{ $class->section }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition font-medium shadow-sm h-[42px]">
                    <i class="fas fa-search mr-2"></i> Fetch Students
                </button>
            </form>
        </div>

        @if(request('source_class_id') && count($students) > 0)
            <form action="{{ route('students.promote') }}" method="POST" id="promotion-form">
                @csrf
                <input type="hidden" name="source_class_id" value="{{ request('source_class_id') }}">

                <!-- Destination Selection -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Select Destination Class (To)</label>
                    <div class="flex gap-4 items-center">
                        <select name="destination_class_id" id="destination_select" required
                            class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                            <option value="">-- Select Target Class --</option>
                            @foreach($classRooms as $class)
                                @if($class->id != request('source_class_id'))
                                    <option value="{{ $class->id }}">{{ $class->name }} {{ $class->section }}</option>
                                @endif
                            @endforeach
                        </select>
                        <button type="button" @click="openModal()"
                            class="bg-blue-600 text-white px-8 py-2.5 rounded-lg hover:bg-blue-700 transition font-medium shadow-sm h-[42px]"
                            style="background-color: #2563eb; color: white;">
                            <i class="fas fa-check-circle mr-2"></i> Promote Selected
                        </button>
                    </div>
                </div>

                <!-- Students List -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-bold text-gray-700">Students in Source Class</h3>
                        <div class="text-sm">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="selectAll"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    checked>
                                <span class="ml-2 text-gray-600">Select All</span>
                            </label>
                        </div>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Select</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Admission No
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gender</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($students as $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" name="students[]" value="{{ $student->id }}" checked
                                            class="student-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->admission_no }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $student->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->gender }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        @elseif(request('source_class_id'))
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <p class="text-yellow-700">No students found in the selected source class.</p>
            </div>
        @endif

        <!-- Confirmation Modal -->
        <div x-show="showConfirmModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm"
            style="display: none;">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 overflow-hidden"
                @click.away="showConfirmModal = false">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-xl font-bold text-gray-900">Confirm Promotion</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                        <div class="flex flex-col gap-2 text-sm text-blue-900">
                            <div class="flex justify-between">
                                <span class="text-blue-600 font-medium">From:</span>
                                <span class="font-bold" x-text="sourceClass"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-blue-600 font-medium">To:</span>
                                <span class="font-bold" x-text="destinationClass"></span>
                            </div>
                            <div class="border-t border-blue-200 my-1"></div>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-600 font-medium">Students Selected:</span>
                                <span class="bg-blue-600 text-white py-0.5 px-2.5 rounded-lg text-xs font-bold"
                                    x-text="selectedCount"></span>
                            </div>
                        </div>
                    </div>

                    <p class="text-sm text-gray-500">
                        Are you sure you want to promote these students? This action will update their class assignment.
                    </p>

                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="showConfirmModal = false"
                            class="flex-1 bg-white border border-gray-300 text-gray-700 py-2.5 rounded-xl hover:bg-gray-50 font-medium transition shadow-sm">
                            Cancel
                        </button>
                        <button type="button" @click="submitForm()"
                            class="flex-1 bg-blue-600 text-white py-2.5 rounded-xl hover:bg-blue-700 font-medium shadow-lg shadow-blue-500/30 transition"
                            style="background-color: #2563eb; color: white;">
                            Confirm Promote
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.getElementById('selectAll')?.addEventListener('change', function (e) {
            const checkboxes = document.querySelectorAll('.student-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
        });
    </script>
</x-master-layout>