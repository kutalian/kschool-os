<x-master-layout>
    @php
        /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\ClassRoom[] $classes */
        /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Subject[] $subjects */
        /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Assignment[] $assignments */
    @endphp
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Assignments</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Upload Assignment Form -->
            <div class="md:col-span-1 bg-white p-6 rounded-lg shadow-md h-fit">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Create Assignment</h2>
                <form action="{{ route('assignments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Class</label>
                        <select name="class_id"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Subject</label>
                        <select name="subject_id"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                        <input type="text" name="title"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Assignment Title" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Instructions (Optional)"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Due Date</label>
                        <input type="datetime-local" name="due_date"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Attachment (Optional)</label>
                        <input type="file" name="file"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                        <p class="text-xs text-gray-500 mt-1">PDF, DOC, IMG (Max 10MB)</p>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                        Create Assignment
                    </button>
                </form>
            </div>

            <!-- Assignments List -->
            <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-700">Recent Assignments</h2>

                    <!-- Filter Form -->
                    <form method="GET" class="flex gap-2">
                        <select name="class_id" class="text-sm border-gray-300 rounded-lg focus:ring-blue-500"
                            onchange="this.form.submit()">
                            <option value="">All Classes</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                                <th class="py-3 px-6">Title</th>
                                <th class="py-3 px-6">Class / Subject</th>
                                <th class="py-3 px-6">Due Date</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse($assignments as $assignment)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="py-3 px-6">
                                        <div class="font-medium text-gray-800">
                                            <a href="{{ route('assignments.show', $assignment->id) }}"
                                                class="hover:text-blue-600 hover:underline">
                                                {{ $assignment->title }}
                                            </a>
                                        </div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($assignment->description, 50) }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-6">
                                        <div class="font-medium">{{ $assignment->class_room->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $assignment->subject->name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="py-3 px-6">
                                        <span
                                            class="text-xs font-semibold px-2 py-1 rounded {{ $assignment->due_date->isPast() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $assignment->due_date->format('M d, Y h:i A') }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            @if($assignment->file_path)
                                                <a href="{{ route('assignments.download', $assignment->id) }}"
                                                    class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 mr-2 transition"
                                                    title="Download Attachment">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif

                                            <a href="{{ route('assignments.delete_confirm', $assignment->id) }}"
                                                class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-200 transition"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-gray-500">No assignments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $assignments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-master-layout>