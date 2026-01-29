<x-master-layout>
    <div class="fade-in">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Apply for Leave</h1>
            <p class="text-sm text-gray-500">Submit a new request for time off</p>
        </div>

        <div class="max-w-3xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <form action="{{ route('staff.leave.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="leave_type" :value="__('Leave Type')" />
                            <select id="leave_type" name="leave_type"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                                required>
                                <option value="">Select Type</option>
                                <option value="Sick Leave" {{ old('leave_type') == 'Sick Leave' ? 'selected' : '' }}>Sick
                                    Leave</option>
                                <option value="Casual Leave" {{ old('leave_type') == 'Casual Leave' ? 'selected' : '' }}>
                                    Casual Leave</option>
                                <option value="Personal Leave" {{ old('leave_type') == 'Personal Leave' ? 'selected' : '' }}>Personal Leave</option>
                                <option value="Bereavement Leave" {{ old('leave_type') == 'Bereavement Leave' ? 'selected' : '' }}>Bereavement Leave</option>
                                <option value="Other" {{ old('leave_type') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('leave_type')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="from_date" :value="__('From Date')" />
                            <x-text-input id="from_date" class="block mt-1 w-full" type="date" name="from_date"
                                :value="old('from_date')" required />
                            <x-input-error :messages="$errors->get('from_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="to_date" :value="__('To Date')" />
                            <x-text-input id="to_date" class="block mt-1 w-full" type="date" name="to_date"
                                :value="old('to_date')" required />
                            <x-input-error :messages="$errors->get('to_date')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="reason" :value="__('Reason for Leave')" />
                        <textarea id="reason" name="reason" rows="4"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                            required placeholder="Briefly describe why you need leave...">{{ old('reason') }}</textarea>
                        <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="attachment" :value="__('Attachment (Optional)')" />
                        <input type="file" id="attachment" name="attachment"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                        <p class="mt-1 text-xs text-gray-500">Medical cert, invitation, or evidence (PDF/JPG up to 2MB)
                        </p>
                        <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50">
                        <a href="{{ route('staff.leave.index') }}"
                            class="px-4 py-2 text-gray-700 hover:text-gray-900 transition">Cancel</a>
                        <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                            {{ __('Submit Application') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-master-layout>