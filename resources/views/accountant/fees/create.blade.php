<x-master-layout>
    <div class="fade-in max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('accountant.fees.index') }}"
                class="text-gray-500 hover:text-blue-600 transition mb-2 inline-block">
                <i class="fas fa-arrow-left mr-1"></i> Back to Fees
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Create New Fee Type</h1>
            <p class="text-gray-500">Define a new fee category (e.g., Tuition, Transport, Lab Fee).</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('accountant.fees.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fee Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            placeholder="e.g. Annual Tuition Fee"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Standard Amount ($) <span
                                    class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" required min="0"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Frequency <span
                                    class="text-red-500">*</span></label>
                            <select name="frequency" required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="One-Time">One-Time</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Quarterly">Quarterly</option>
                                <option value="Annually">Annually</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                        <textarea name="description" rows="3"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit"
                            class="px-6 py-2 rounded-lg bg-blue-600 text-white font-bold hover:bg-blue-700 transition shadow-sm">
                            Create Fee Type
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>