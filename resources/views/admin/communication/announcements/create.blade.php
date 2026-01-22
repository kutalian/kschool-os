<x-master-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Create Announcement</h1>
            <a href="{{ route('announcements.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('announcements.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" id="title"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>

                    <div class="col-span-2">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                        <textarea name="content" id="content" rows="4"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required></textarea>
                    </div>

                    <div>
                        <label for="announcement_type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="announcement_type" id="announcement_type"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="General">General</option>
                            <option value="Academic">Academic</option>
                            <option value="Event">Event</option>
                            <option value="Emergency">Emergency</option>
                            <option value="Holiday">Holiday</option>
                        </select>
                    </div>

                    <div>
                        <label for="target_audience" class="block text-sm font-medium text-gray-700 mb-1">Target
                            Audience</label>
                        <select name="target_audience" id="target_audience"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="All">All</option>
                            <option value="Students">Students</option>
                            <option value="Staff">Staff</option>
                            <option value="Parents">Parents</option>
                            <option value="Class">Class</option>
                        </select>
                    </div>

                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                        <select name="priority" id="priority"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="Normal">Normal</option>
                            <option value="Low">Low</option>
                            <option value="High">High</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="datetime-local" name="start_date" id="start_date"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="datetime-local" name="end_date" id="end_date"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Create Announcement
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-master-layout>