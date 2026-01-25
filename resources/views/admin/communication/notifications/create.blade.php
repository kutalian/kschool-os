<x-master-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Send Notification</h1>
        <a href="{{ route('notifications.manager.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6 max-w-2xl mx-auto">
        <form action="{{ route('notifications.manager.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="target_audience" class="block text-sm font-medium text-gray-700">Target Audience <span
                        class="text-red-500">*</span></label>
                <select name="target_audience" id="target_audience"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="student">Students</option>
                    <option value="staff">Staff</option>
                    <option value="parent">Parents</option>
                    <option value="all">All Users</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="channel" class="block text-sm font-medium text-gray-700">Channel <span
                        class="text-red-500">*</span></label>
                <select name="channel" id="channel"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="email">Email Only</option>
                    <option value="sms">SMS Only</option>
                    <option value="both">Both Email & SMS</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="subject" class="block text-sm font-medium text-gray-700">Subject <span
                        class="text-red-500">*</span></label>
                <input type="text" name="subject" id="subject"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
            </div>

            <div class="mb-6">
                <label for="message" class="block text-sm font-medium text-gray-700">Message <span
                        class="text-red-500">*</span></label>
                <textarea name="message" id="message" rows="5"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required></textarea>
                <p class="text-xs text-gray-500 mt-1">Note: For SMS, message will be stripped of formatting.</p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Queue Notification
                </button>
            </div>
        </form>
    </div>
</x-master-layout>