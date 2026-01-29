<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Lesson Plans</h1>
                <p class="text-sm text-gray-500">Plan and track your teaching progress</p>
            </div>
            <a href="{{ route('staff.lesson-plans.create') }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                <i class="fas fa-plus text-sm"></i>
                New Lesson Plan
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Topic</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Class & Subject</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($lessonPlans as $plan)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">{{ $plan->topic }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-700">{{ $plan->class_room->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $plan->subject->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700">{{ $plan->week_start_date->format('M d, Y') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full capitalize">{{ $plan->status ?? 'Draft' }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('staff.lesson-plans.show', $plan) }}"
                                            class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                            title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('staff.lesson-plans.edit', $plan) }}"
                                            class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('staff.lesson-plans.destroy', $plan) }}" method="POST"
                                            class="inline-block" onsubmit="return confirm('Delete this lesson plan?')">
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
                                    No lesson plans found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($lessonPlans->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $lessonPlans->links() }}
                </div>
            @endif
        </div>
    </div>
</x-master-layout>