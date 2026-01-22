<x-master-layout>
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">Add New Visitor</h1>
            <a href="{{ route('visitors.index') }}"
                class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('visitors.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Visitor Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            required placeholder="John Doe">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="phone"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            required placeholder="+234...">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Purpose <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="purpose"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            required placeholder="e.g. Admission Inquiry">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meeting With</label>
                        <input type="text" name="person_to_meet"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            placeholder="e.g. Principal">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ID Proof / Card No</label>
                        <input type="text" name="id_proof"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            placeholder="e.g. National ID 12345">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Check In Time <span
                                class="text-red-500">*</span></label>
                        <input type="datetime-local" name="check_in" value="{{ now()->format('Y-m-d\TH:i') }}"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Number of Persons</label>
                        <input type="number" name="no_of_persons" min="1" value="1"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Note (Optional)</label>
                        <textarea name="note" rows="3"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            placeholder="Additional remarks..."></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="reset"
                        class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">Reset</button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm">Save
                        Visitor</button>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>