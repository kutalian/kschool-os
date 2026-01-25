<x-master-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Alumni Profile</h1>
        <div>
            <a href="{{ route('alumni.edit', $alumni->id) }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <a href="{{ route('alumni.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 text-center border-b">
                    <div
                        class="h-24 w-24 rounded-full bg-gray-200 mx-auto flex items-center justify-center text-gray-500 text-3xl mb-4">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $alumni->name }}</h2>
                    <p class="text-gray-500">{{ $alumni->current_occupation ?? 'Alumni' }}</p>
                    <p class="text-sm text-gray-400">{{ $alumni->company_name }}</p>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Contact Info</span>
                        <div class="mt-2 text-sm text-gray-700">
                            <p><i class="fas fa-envelope w-6 text-gray-400"></i> {{ $alumni->email ?? 'N/A' }}</p>
                            <p class="mt-2"><i class="fas fa-phone w-6 text-gray-400"></i> {{ $alumni->phone ?? 'N/A' }}
                            </p>
                            @if($alumni->linkedin_url)
                                <p class="mt-2"><i class="fab fa-linkedin w-6 text-blue-600"></i> <a
                                        href="{{ $alumni->linkedin_url }}" target="_blank"
                                        class="text-blue-600 hover:underline">LinkedIn Profile</a></p>
                            @endif
                        </div>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Academic Info</span>
                        <div class="mt-2 text-sm text-gray-700">
                            <p><strong>Graduation Year:</strong> {{ $alumni->graduation_year }}</p>
                            <p><strong>Class:</strong> {{ $alumni->graduation_class ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @if($alumni->address)
                        <div>
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Address</span>
                            <p class="mt-1 text-sm text-gray-700">{{ $alumni->address }}</p>
                        </div>
                    @endif

                    <div class="pt-4 border-t">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Willing to Mentor?</span>
                            @if($alumni->willing_to_mentor)
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes</span>
                            @else
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">No</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-sm text-gray-700">Status</span>
                            @if($alumni->is_active)
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Donations Section -->
        <div class="md:col-span-2">
            <!-- Add Donation Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Record New Donation</h3>
                <form action="{{ route('alumni.donations.store', $alumni->id) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Amount</label>
                            <input type="number" name="amount" min="0" step="0.01"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="donation_date" value="{{ date('Y-m-d') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                            <select name="payment_method"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Cash">Cash</option>
                                <option value="Online">Online</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Transaction ID (Optional)</label>
                            <input type="text" name="transaction_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Purpose / Remarks</label>
                            <input type="text" name="purpose" placeholder="e.g. Library Fund, General Donation"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            Record Donation
                        </button>
                    </div>
                </form>
            </div>

            <!-- Donation History Dictionary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-bold text-gray-800">Donation History</h3>
                </div>
                @if($alumni->donations->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Method</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Purpose</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($alumni->donations as $donation)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $donation->donation_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                        {{ number_format($donation->amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $donation->payment_method }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $donation->purpose ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td class="px-6 py-3 text-right font-bold text-gray-900">Total:</td>
                                <td class="px-6 py-3 font-bold text-green-600">
                                    {{ number_format($alumni->donations->sum('amount'), 2) }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <div class="p-6 text-center text-gray-500">
                        No donations recorded yet.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-master-layout>