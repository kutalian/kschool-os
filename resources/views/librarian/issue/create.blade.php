<x-master-layout>
    <div class="fade-in max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Issue Book</h1>
            <p class="text-gray-500">Select a student and a book to issue.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('librarian.issue.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Student <span
                                class="text-red-500">*</span></label>
                        <select name="student_id" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Choose Student...</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->first_name }} {{ $student->last_name }} ({{ $student->admission_number }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Only students with valid accounts are listed.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Book <span
                                class="text-red-500">*</span></label>
                        <select name="book_id" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Choose Book...</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}">
                                    {{ $book->title }} - {{ $book->author }} ({{ $book->isbn ?? 'No ISBN' }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Only books with available copies are shown.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Due Date <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="due_date" required min="{{ date('Y-m-d') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Remarks (Optional)</label>
                        <textarea name="remarks" rows="2"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit"
                            class="px-6 py-2 rounded-lg bg-blue-600 text-white font-bold hover:bg-blue-700 transition shadow-sm">
                            Confirm Issue
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>