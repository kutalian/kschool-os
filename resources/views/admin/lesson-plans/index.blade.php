<x-master-layout>
    @php
        /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\LessonPlan[] $lessonPlans */
        /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\ClassRoom[] $classes */
    @endphp

    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Lesson Plans</h1>
            <a href="{{ route('lesson-plans.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
                <i class="fas fa-plus mr-2"></i> Create New Plan
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('lesson-plans.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Filter by Class</label>
                    <select name="class_id" id="class_id"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Filter by Status</label>
                    <select name="status" id="status"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded shadow transition w-full md:w-auto">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                    @if(request('class_id') || request('status') || request('trashed'))
                        <a href="{{ route('lesson-plans.index') }}"
                            class="ml-2 text-gray-500 hover:text-gray-700 font-medium py-2">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
            <div class="mt-4 flex justify-end">
                <a href="{{ route('lesson-plans.index', ['trashed' => 1]) }}"
                    class="{{ request('trashed') ? 'text-red-700 font-bold' : 'text-gray-500 hover:text-red-600' }} text-sm">
                    <i class="fas fa-trash-alt mr-1"></i> View Trash
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Week
                            Of</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class
                            & Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Topic
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Teacher</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($lessonPlans as $plan)
                        @php /** @var \App\Models\LessonPlan $plan */ @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $plan->week_start_date ? \Illuminate\Support\Carbon::parse($plan->week_start_date)->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $plan->class_room->name }}</div>
                                <div class="text-sm text-gray-500">{{ $plan->subject->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="max-w-xs truncate" title="{{ $plan->topic }}">
                                    {{ $plan->topic }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $plan->teacher->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $plan->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $plan->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $plan->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($plan->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if(request('trashed'))
                                    <!-- Restore / Force Delete -->
                                    <form action="{{ route('lesson-plans.restore', $plan->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900 mr-3" title="Restore">
                                            <i class="fas fa-trash-restore"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('lesson-plans.force_delete', $plan->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Permanently delete this plan? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-700 hover:text-red-900 font-bold"
                                            title="Delete Permanently">
                                            <i class="fas fa-times"></i> Delete
                                        </button>
                                    </form>
                                @else
                                    <!-- Normal Actions -->
                                    <a href="{{ route('lesson-plans.show', $plan->id) }}"
                                        class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @if((auth()->user()->role === 'admin' || auth()->id() === $plan->teacher_id) && $plan->status !== 'approved')
                                        <a href="{{ route('lesson-plans.edit', $plan->id) }}"
                                            class="text-yellow-600 hover:text-yellow-900 mr-3">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    @endif
                                    @if(auth()->user()->role === 'admin' || auth()->id() === $plan->teacher_id)
                                        <form action="{{ route('lesson-plans.destroy', $plan->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this plan?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No lesson plans found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $lessonPlans->links() }}
        </div>
    </div>
</x-master-layout>