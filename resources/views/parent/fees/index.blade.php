<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fee Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Select Child to View Fees</h3>

                    @if($children->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($children as $child)
                                <a href="{{ route('parent.fees.show', $child->id) }}"
                                    class="block p-6 border rounded-lg hover:shadow-lg transition bg-gray-50 hover:bg-white">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-lg">
                                            {{ substr($child->first_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800">{{ $child->first_name }} {{ $child->last_name }}
                                            </h4>
                                            <p class="text-sm text-gray-500">Class: {{ $child->class_room->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            No children associated with your account.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>