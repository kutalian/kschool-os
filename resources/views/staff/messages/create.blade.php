<x-master-layout>
    <div class="fade-in pb-12">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Compose Message</h1>
            <p class="text-sm text-gray-500">Send a message to a parent or administrator</p>
        </div>

        <div class="max-w-4xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <form action="{{ route('staff.messages.store') }}" method="POST" class="space-y-6">
                    @csrf

                    @if($replyTo)
                        <input type="hidden" name="parent_message_id" value="{{ $replyTo->id }}">
                        <input type="hidden" name="receiver_id" value="{{ $replyTo->sender_id }}">

                        <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-4 mb-6">
                            <div class="text-xs font-semibold text-indigo-700 uppercase mb-1">Replying to:</div>
                            <div class="text-sm font-bold text-gray-800">{{ $replyTo->sender->name }}</div>
                            <div class="text-sm text-gray-600 italic">"{{ Str::limit($replyTo->message, 100) }}"</div>
                        </div>
                    @else
                        <!-- Recipient Selection -->
                        <div>
                            <label for="receiver_id" class="block text-sm font-medium text-gray-700 mb-1">Send To</label>
                            <select name="receiver_id" id="receiver_id" required
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition">
                                <option value="">Select Recipient</option>
                                @foreach($recipients as $recipient)
                                    <option value="{{ $recipient->id }}" {{ old('receiver_id') == $recipient->id ? 'selected' : '' }}>
                                        {{ $recipient->name }} ({{ ucfirst($recipient->role) }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500 italic">You can message any staff member, or students and parents in your assigned classes.</p>
                            @error('receiver_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text" name="subject" id="subject"
                            value="{{ old('subject', $replyTo ? 'Re: ' . $replyTo->subject : '') }}" required
                            placeholder="Message subject..."
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition">
                        @error('subject') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea name="message" id="message" rows="8" required placeholder="Type your message here..."
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition">{{ old('message') }}</textarea>
                        @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('staff.messages.index') }}"
                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-md transition flex items-center gap-2">
                            <i class="fas fa-paper-plane text-sm"></i>
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-master-layout>