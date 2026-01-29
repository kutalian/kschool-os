<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Exam Questions</h1>
                <p class="text-sm text-gray-500">Submit and track your exam question papers</p>
            </div>
            <a href="{{ route('staff.exam-questions.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center gap-2">
                <i class="fas fa-plus text-sm"></i>
                Submit Questions
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Title</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Class & Subject</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Exam</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($questions as $question)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">{{ $question->title }}</div>
                                    <div class="text-xs text-gray-400">{{ $question->created_at->format('M d, Y') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-700">{{ $question->class_room->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $question->subject->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700">{{ $question->exam->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'approved' => 'bg-green-100 text-green-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses[$question->status] ?? 'bg-gray-100' }}">
                                        {{ ucfirst($question->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('staff.exam-questions.show', $question) }}"
                                            class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($question->status === 'pending')
                                            <a href="{{ route('staff.exam-questions.edit', $question) }}"
                                                class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('staff.exam-questions.destroy', $question) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this submission?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    No exam questions submitted yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($questions->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $questions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-master-layout>
