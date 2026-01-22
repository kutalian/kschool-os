<x-master-layout>
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Compose Message</h1>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('messages.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Recipient</label>
                            <select name="receiver_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                <option value="">Select Recipient</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Subject</label>
                            <input type="text" name="subject"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required placeholder="Enter subject">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Message</label>
                            <textarea name="message" rows="6"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required placeholder="Type your message here..."></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('messages.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2 hover:bg-gray-600">Cancel</a>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Send
                            Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-master-layout>