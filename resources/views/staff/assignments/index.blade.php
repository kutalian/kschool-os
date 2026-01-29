<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Assignments</h1>
                <p class="text-sm text-gray-500">Manage and track student assignments</p>
            </div>
            <a href="{{ route('staff.assignments.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                <i class="fas fa-plus text-sm"></i>
                Create Assignment
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Title</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Class & Subject</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Due Date</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($assignments as $assignment)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">{{ $assignment->title }}</div>
                                    @if($assignment->file_path)
                                        <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank"
                                            class="text-xs text-blue-600 hover:underline">
                                            <i class="fas fa-paperclip mr-1"></i> Attachment
                                        </a>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-700">{{ $assignment->class_room->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $assignment->subject->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700">{{ $assignment->due_date->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $assignment->due_date->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($assignment->due_date->isPast())
                                        <span
                                            class="px-2 py-1 text-xs font-medium bg-red-100 text-red-600 rounded-full">Closed</span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-medium bg-green-100 text-green-600 rounded-full">Active</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('staff.assignments.submissions', $assignment) }}"
                                            class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                            title="View Submissions">
                                            <i class="fas fa-users"></i>
                                        </a>
                                        <a href="{{ route('staff.assignments.edit', $assignment) }}"
                                            class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('staff.assignments.destroy', $assignment) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this assignment?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-clipboard-list text-4xl mb-4 text-gray-200"></i>
                                        <p>No assignments found. Start by creating one!</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($assignments->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $assignments->links() }}
                </div>
            @endif
        </div>
    </div>
</x-master-layout>