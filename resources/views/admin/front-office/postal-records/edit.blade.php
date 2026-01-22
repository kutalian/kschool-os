<x-master-layout>
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">Edit Postal Record</h1>
            <a href="{{ route('postal-records.index') }}"
                class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('postal-records.update', $postalRecord) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Record Type <span
                                class="text-red-500">*</span></label>
                        <div class="flex gap-4 mt-1">
                            <label class="inline-flex items-center">
                                <input type="radio" name="type" value="Receive" {{ $postalRecord->type == 'Receive' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-gray-700">Receive (Inward)</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="type" value="Dispatch" {{ $postalRecord->type == 'Dispatch' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-gray-700">Dispatch (Outward)</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reference No</label>
                        <input type="text" name="reference_no" value="{{ $postalRecord->reference_no }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sender Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="sender_name" value="{{ $postalRecord->sender_name }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Receiver Name</label>
                        <input type="text" name="receiver_name" value="{{ $postalRecord->receiver_name }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="date" value="{{ $postalRecord->date->format('Y-m-d') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <textarea name="address" rows="2"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ $postalRecord->address }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Note / Description</label>
                        <textarea name="note" rows="3"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ $postalRecord->note }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm">Update
                        Record</button>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>