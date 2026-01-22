<x-master-layout>
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Create New Event</h1>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('events.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Event Title</label>
                            <input type="text" name="title"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Event Type</label>
                            <select name="event_type"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                                <option value="Other">Other</option>
                                <option value="Holiday">Holiday</option>
                                <option value="Exam">Exam</option>
                                <option value="Meeting">Meeting</option>
                                <option value="Sports">Sports</option>
                                <option value="Cultural">Cultural</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Audience</label>
                            <select name="audience"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                                <option value="all">All</option>
                                <option value="student">Students</option>
                                <option value="staff">Staff</option>
                                <option value="parent">Parents</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Start Time</label>
                            <input type="time" name="start_time"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">End Time</label>
                            <input type="time" name="end_time"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Venue</label>
                            <input type="text" name="venue"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                        </div>

                        <div class="col-span-1 md:col-span-2 flex items-center">
                            <input type="checkbox" name="is_holiday" id="is_holiday"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <label for="is_holiday" class="ml-2 block text-sm text-gray-900">Mark as Holiday</label>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('events.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2 hover:bg-gray-600">Cancel</a>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Create Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-master-layout>