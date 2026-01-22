<x-master-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Issue Certificate</h1>
        <a href="{{ route('certificates.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl mx-auto">
        <form action="{{ route('certificates.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Select Student</label>
                <select name="student_id" id="student_id"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                    <option value="">Search Student...</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->id }})</option>
                    @endforeach
                </select>
                @error('student_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="certificate_type" class="block text-sm font-medium text-gray-700 mb-1">Certificate
                    Type</label>
                <select name="certificate_type" id="certificate_type"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                    <option value="Leaving Certificate">Leaving Certificate</option>
                    <option value="Character Certificate">Character Certificate</option>
                    <option value="Bonafide Certificate">Bonafide Certificate</option>
                    <option value="Transfer Certificate">Transfer Certificate</option>
                    <option value="Achievement Certificate">Achievement Certificate</option>
                    <option value="Testimonial Certificate">Testimonial Certificate</option>
                </select>
                @error('certificate_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="unique_code" class="block text-sm font-medium text-gray-700 mb-1">Certificate Code</label>
                <input type="text" name="unique_code" id="unique_code" value="{{ 'CERT-' . strtoupper(uniqid()) }}"
                    class="w-full rounded-lg border-gray-300 bg-gray-100" readonly>
                <p class="text-xs text-gray-500 mt-1">Auto-generated unique code</p>
                @error('unique_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="issue_date" class="block text-sm font-medium text-gray-700 mb-1">Issue Date</label>
                <input type="date" name="issue_date" id="issue_date" value="{{ date('Y-m-d') }}"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                @error('issue_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content / Remarks
                    (Optional)</label>
                <textarea name="content" id="content" rows="4"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"></textarea>
                @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Issue Certificate
                </button>
            </div>
        </form>
    </div>
</x-master-layout>