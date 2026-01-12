<x-master-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Lesson Plan Details</h1>
            <a href="{{ route('lesson-plans.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                <i class="fas fa-arrow-left mr-1"></i> Back to List
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Header Status -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <div>
                    <span class="text-sm text-gray-500 block">Status</span>
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full mt-1
                        {{ $lessonPlan->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $lessonPlan->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $lessonPlan->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($lessonPlan->status) }}
                    </span>
                </div>
                <div class="text-right">
                    <span class="text-sm text-gray-500 block">Submitted By</span>
                    <span class="font-medium text-gray-900">{{ $lessonPlan->teacher->name }}</span>
                    <span
                        class="text-xs text-gray-400 block">{{ $lessonPlan->created_at->format('M d, Y h:i A') }}</span>
                </div>
            </div>

            <div class="p-6">
                <!-- Rejection Remarks -->
                @if($lessonPlan->status === 'rejected' && $lessonPlan->admin_remarks)
                    <div class="mb-8 bg-red-50 border-l-4 border-red-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-times-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Plan Rejected</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p class="font-bold">Admin Remarks:</p>
                                    <p>{{ $lessonPlan->admin_remarks }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Plan Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Class & Subject</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $lessonPlan->class_room->name }} -
                            {{ $lessonPlan->subject->name }}
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Week Starting</h3>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $lessonPlan->week_start_date->format('l, F j, Y') }}
                        </p>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Topic / Unit</h3>
                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200 text-gray-900">
                        {{ $lessonPlan->topic }}
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Learning Objectives</h3>
                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200 text-gray-900 whitespace-pre-wrap">
                        {{ $lessonPlan->objectives }}
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Resources Needed</h3>
                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200 text-gray-900 whitespace-pre-wrap">
                        {{ $lessonPlan->resources_needed ?? 'None specified.' }}
                    </div>
                </div>

                @if($lessonPlan->attachment)
                    <div class="mb-8">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Attachment</h3>
                        <a href="{{ Storage::url($lessonPlan->attachment) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 border border-blue-300 shadow-sm text-sm font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-paperclip mr-2"></i> Download / View Attachment
                        </a>
                    </div>
                @endif

                <!-- Admin Actions -->
                @if(auth()->user()->role === 'admin' && $lessonPlan->status === 'pending')
                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Admin Actions</h3>

                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Approve Action -->
                            <div class="flex-1 bg-green-50 p-4 rounded-lg border border-green-200">
                                <h4 class="font-bold text-green-800 mb-2">Approve Plan</h4>
                                <p class="text-sm text-green-700 mb-4">Mark this lesson plan as approved. The teacher will
                                    be notified.</p>
                                <form action="{{ route('lesson-plans.approve', $lessonPlan->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow transition">
                                        <i class="fas fa-check mr-2"></i> Approve Plan
                                    </button>
                                </form>
                            </div>

                            <!-- Reject Action -->
                            <div class="flex-1 bg-red-50 p-4 rounded-lg border border-red-200">
                                <h4 class="font-bold text-red-800 mb-2">Reject Plan</h4>
                                <p class="text-sm text-red-700 mb-4">Reject this plan and provide feedback for the teacher.
                                </p>
                                <form action="{{ route('lesson-plans.reject', $lessonPlan->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                        <textarea name="admin_remarks" rows="3" required
                                            placeholder="Reason for rejection..."
                                            class="w-full rounded-md border-red-300 focus:border-red-500 focus:ring-red-500 text-sm"></textarea>
                                    </div>
                                    <button type="submit"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow transition">
                                        <i class="fas fa-times mr-2"></i> Reject Plan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                @if((auth()->user()->role === 'admin' || auth()->id() === $lessonPlan->teacher_id) && $lessonPlan->status !== 'approved')
                    <div class="border-t border-gray-200 pt-6 mt-6 flex justify-end">
                        <a href="{{ route('lesson-plans.edit', $lessonPlan->id) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded shadow transition mr-2">
                            <i class="fas fa-edit mr-2"></i> Edit Plan
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-master-layout>