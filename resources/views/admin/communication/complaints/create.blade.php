<x-master-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Register Complaint</h1>
            <a href="{{ route('complaints.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('complaints.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category" id="category"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="Other">Other</option>
                            <option value="Academic">Academic</option>
                            <option value="Discipline">Discipline</option>
                            <option value="Facility">Facility</option>
                            <option value="Transport">Transport</option>
                            <option value="Fee">Fee</option>
                        </select>
                    </div>

                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                        <select name="priority" id="priority"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                            <option value="High">High</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text" name="subject" id="subject"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>

                    <div class="col-span-2">
                        <label for="description"
                            class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Submit Complaint
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>