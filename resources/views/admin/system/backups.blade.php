<x-master-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">System Backups</h1>
                <p class="text-sm text-gray-500 mt-1">Manage and download your database backups.</p>
            </div>
            <form action="{{ route('system.backups.create') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl transition duration-200 shadow-sm flex items-center">
                    <i class="fas fa-database mr-2"></i> Create New Backup
                </button>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-emerald-500 mr-3 text-lg"></i>
                    <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border-l-4 border-rose-500 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-rose-500 mr-3 text-lg"></i>
                    <p class="text-rose-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Started At</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Type</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                File Size</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Initiated By</th>
                            <th
                                class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($logs as $log)
                            <tr class="hover:bg-gray-50/50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                    {{ $log->started_at->format('M d, Y H:i:s') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                        {{ $log->backup_type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $log->file_size ? round($log->file_size / 1024 / 1024, 2) . ' MB' : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClasses = [
                                            'Completed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                            'Failed' => 'bg-rose-100 text-rose-800 border-rose-200',
                                            'In Progress' => 'bg-amber-100 text-amber-800 border-amber-200',
                                        ];
                                        $class = $statusClasses[$log->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                    @endphp
                                    <span
                                        class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $class }}">
                                        {{ $log->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <div class="h-7 w-7 rounded-full bg-gray-100 flex items-center justify-center mr-2">
                                            <i class="fas fa-user text-[10px] text-gray-400"></i>
                                        </div>
                                        {{ $log->creator->name ?? 'System' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if ($log->status === 'Completed')
                                        <a href="{{ route('system.backups.download', $log->id) }}"
                                            class="text-blue-600 hover:text-blue-900 inline-flex items-center transition duration-150">
                                            <i class="fas fa-download mr-1.5"></i> Download
                                        </a>
                                    @elseif ($log->status === 'Failed')
                                        <button title="{{ $log->error_message }}"
                                            class="text-rose-600 hover:text-rose-900 inline-flex items-center transition duration-150 cursor-help"
                                            onclick="alert('Error: {{ addslashes($log->error_message) }}')">
                                            <i class="fas fa-info-circle mr-1.5"></i> Error
                                        </button>
                                    @else
                                        <span class="text-gray-400 italic">Processing...</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="h-16 w-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-database text-gray-300 text-2xl"></i>
                                        </div>
                                        <p class="text-gray-500 font-medium">No backup logs found.</p>
                                        <p class="text-gray-400 text-sm mt-1">Create your first backup to see it here.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
                <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-master-layout>