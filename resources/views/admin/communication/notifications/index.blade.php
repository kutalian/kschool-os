<x-master-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Notification Manager</h1>
        <div class="space-x-2">
            <form action="{{ route('notifications.manager.process') }}" method="POST" class="inline-block">
                @csrf
                <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-sync-alt mr-2"></i> Process Queue
                </button>
            </form>
            <a href="{{ route('notifications.manager.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-paper-plane mr-2"></i> Send New
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pending in Queue</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $queueCount }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Emails Sent Today</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $emailCount }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">SMS Sent Today</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $smsCount }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full text-green-600">
                    <i class="fas fa-sms"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Queue -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-bold text-gray-800">Recent Queue Items</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <tbody class="divide-y divide-gray-200">
                        @forelse($queueItems as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <span class="block text-sm font-medium text-gray-900">{{ $item->recipient_type }} to
                                        {{ $item->recipient_email ?? $item->recipient_phone }}</span>
                                    <span class="block text-xs text-gray-500">{{ $item->subject }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ $item->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">Queue is empty</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- System Logs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-bold text-gray-800">Recent Logs</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <tbody class="divide-y divide-gray-200">
                        @forelse($emailLogs as $log)
                            <tr>
                                <td class="px-6 py-4">
                                    <span class="block text-sm font-medium text-gray-900">Email:
                                        {{ $log->recipient_email }}</span>
                                    <span class="block text-xs text-gray-500">{{ $log->subject }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-xs text-gray-500">{{ $log->sent_at->diffForHumans() }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">No logs found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-master-layout>