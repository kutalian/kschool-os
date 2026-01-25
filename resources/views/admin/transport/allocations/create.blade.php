<x-master-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Allocate Transport</h1>
        <a href="{{ route('transport.allocations.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6 max-w-2xl mx-auto">
        <form action="{{ route('transport.allocations.store') }}" method="POST">
            @csrf

            <div class="mb-4 relative" x-data="{ 
                query: '', 
                students: [], 
                selectedStudent: null,
                search() {
                    if (this.query.length < 2) { this.students = []; return; }
                    fetch('{{ route('transport.allocations.search') }}?q=' + this.query)
                        .then(res => res.json())
                        .then(data => this.students = data);
                },
                select(student) {
                    this.selectedStudent = student;
                    this.query = student.name + ' (' + student.admission_no + ')';
                    document.getElementById('student_id').value = student.id;
                    this.students = [];
                }
            }">
                <label for="student_search" class="block text-sm font-medium text-gray-700">Find Student <span
                        class="text-red-500">*</span></label>
                <input type="text" x-model="query" @input.debounce.300ms="search()" autocomplete="off"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Type name or admission number...">
                <input type="hidden" name="student_id" id="student_id" required>

                <div x-show="students.length > 0"
                    class="absolute z-10 w-full bg-white border border-gray-200 mt-1 rounded-md shadow-lg max-h-60 overflow-y-auto">
                    <template x-for="student in students" :key="student.id">
                        <div @click="select(student)"
                            class="cursor-pointer px-4 py-2 hover:bg-gray-50 border-b last:border-b-0">
                            <span x-text="student.name" class="font-bold block"></span>
                            <span x-text="student.admission_no" class="text-sm text-gray-500"></span>
                        </div>
                    </template>
                </div>
            </div>

            <div class="mb-4">
                <label for="route_id" class="block text-sm font-medium text-gray-700">Select Route <span
                        class="text-red-500">*</span></label>
                <select name="route_id" id="route_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
                    <option value="">-- Choose Route --</option>
                    @foreach($routes as $route)
                        <option value="{{ $route->id }}">
                            {{ $route->route_name }} - ₦{{ number_format($route->fare, 2) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="pickup_point" class="block text-sm font-medium text-gray-700">Pickup Point</label>
                <input type="text" name="pickup_point" id="pickup_point"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="e.g. Main Gate, Bus Stop A">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Assign Route
                </button>
            </div>
        </form>
    </div>
</x-master-layout>