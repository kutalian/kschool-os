<x-master-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">School Events</h1>
            <a href="{{ route('events.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-calendar-plus mr-2"></i> Add Event
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-sm"
                role="alert">
                <strong class="font-bold"><i class="fas fa-check-circle mr-1"></i> Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-200">
                    <div class="h-2" style="background-color: {{ $event->color ?? '#3498db' }}"></div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">
                                {{ ucfirst($event->event_type) }}
                            </span>
                            @if($event->is_holiday)
                                <span class="text-red-500" title="Holiday"><i class="fas fa-umbrella-beach"></i></span>
                            @endif
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mb-2 truncate" title="{{ $event->title }}">
                            {{ $event->title }}</h3>

                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <div class="flex items-center">
                                <i class="far fa-calendar-alt w-5 text-gray-400"></i>
                                <span>{{ $event->start_date->format('M d, Y') }} @if($event->start_date != $event->end_date)
                                - {{ $event->end_date->format('M d, Y') }} @endif</span>
                            </div>
                            @if($event->start_time)
                                <div class="flex items-center">
                                    <i class="far fa-clock w-5 text-gray-400"></i>
                                    <span>{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} @if($event->end_time)
                                    - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }} @endif</span>
                                </div>
                            @endif
                            @if($event->venue)
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt w-5 text-gray-400"></i>
                                    <span class="truncate">{{ $event->venue }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="pt-4 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-xs text-gray-500">Audience: {{ ucfirst($event->audience) }}</span>
                            <div class="flex space-x-2">
                                <a href="{{ route('events.edit', $event->id) }}"
                                    class="text-yellow-600 hover:text-yellow-900 transition"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Delete this event?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 transition"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $events->links() }}
        </div>
    </div>
</x-master-layout>