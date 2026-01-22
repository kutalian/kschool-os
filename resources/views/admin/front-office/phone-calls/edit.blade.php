<x-master-layout>
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">Edit Call Log</h1>
            <a href="{{ route('phone-call-logs.index') }}"
                class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('phone-call-logs.update', $phoneCallLog) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ $phoneCallLog->phone }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Caller/Receiver Name</label>
                        <input type="text" name="name" value="{{ $phoneCallLog->name }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date & Time <span
                                class="text-red-500">*</span></label>
                        <input type="datetime-local" name="date" value="{{ $phoneCallLog->date->format('Y-m-d\TH:i') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                        <input type="text" name="duration" value="{{ $phoneCallLog->duration }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Call Type <span
                                class="text-red-500">*</span></label>
                        <div class="flex gap-4 mt-1">
                            <label class="inline-flex items-center">
                                <input type="radio" name="call_type" value="Incoming" {{ $phoneCallLog->call_type == 'Incoming' ? 'checked' : '' }}
                                    class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-gray-700">Incoming</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="call_type" value="Outgoing" {{ $phoneCallLog->call_type == 'Outgoing' ? 'checked' : '' }}
                                    class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-gray-700">Outgoing</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Follow Up Date</label>
                        <input type="date" name="follow_up_date"
                            value="{{ $phoneCallLog->follow_up_date ? $phoneCallLog->follow_up_date->format('Y-m-d') : '' }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description / Note</label>
                        <textarea name="description" rows="3"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ $phoneCallLog->description }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm">Update
                        Log</button>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>