<x-master-layout>
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">Edit Enquiry</h1>
            <a href="{{ route('admission-enquiries.index') }}"
                class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('admission-enquiries.update', $admissionEnquiry) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Applicant Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ $admissionEnquiry->name }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ $admissionEnquiry->phone }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ $admissionEnquiry->email }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Class Applying For</label>
                        <input type="text" name="class_applying_for" value="{{ $admissionEnquiry->class_applying_for }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Enquiry Date <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="date"
                            value="{{ $admissionEnquiry->date ? $admissionEnquiry->date->format('Y-m-d') : '' }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Next Follow Up Date</label>
                        <input type="date" name="next_follow_up"
                            value="{{ $admissionEnquiry->next_follow_up ? $admissionEnquiry->next_follow_up->format('Y-m-d') : '' }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. of Children</label>
                        <input type="number" name="no_of_children" value="{{ $admissionEnquiry->no_of_children }}"
                            min="1"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                            <option value="Pending" {{ $admissionEnquiry->status == 'Pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="Contacted" {{ $admissionEnquiry->status == 'Contacted' ? 'selected' : '' }}>
                                Contacted</option>
                            <option value="Visited" {{ $admissionEnquiry->status == 'Visited' ? 'selected' : '' }}>Visited
                            </option>
                            <option value="Admitted" {{ $admissionEnquiry->status == 'Admitted' ? 'selected' : '' }}>
                                Admitted</option>
                            <option value="Rejected" {{ $admissionEnquiry->status == 'Rejected' ? 'selected' : '' }}>
                                Rejected</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description / Notes</label>
                        <textarea name="description" rows="3"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ $admissionEnquiry->description }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <textarea name="address" rows="2"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ $admissionEnquiry->address }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm">Update
                        Enquiry</button>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>