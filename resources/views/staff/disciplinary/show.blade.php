<x-master-layout>
    <div class="fade-in">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Incident Details</h1>
                <p class="text-sm text-gray-500">View information about a reported student incident</p>
            </div>
            <a href="{{ route('staff.disciplinary.index') }}"
                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
                <i class="fas fa-arrow-left text-sm"></i>
                Back to List
            </a>
        </div>

        <div class="max-w-3xl">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 space-y-8">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 text-xl font-bold">
                                {{ substr($disciplinary->student->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">{{ $disciplinary->student->user->name }}
                                </h3>
                                <p class="text-gray-500 italic">Roll Number: {{ $disciplinary->student->roll_number }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div
                                class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $disciplinary->handled_by ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $disciplinary->handled_by ? 'Handled' : 'Pending Review' }}
                            </div>
                            <p class="text-xs text-gray-400 mt-2">Reported on
                                {{ $disciplinary->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-8 py-6 border-t border-b border-gray-50">
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-1">Incident Type</p>
                            <p class="text-gray-800 font-medium">{{ $disciplinary->incident_type }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-1">Date of Incident
                            </p>
                            <p class="text-gray-800 font-medium">{{ $disciplinary->incident_date->format('F d, Y') }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-2">Description</p>
                        <div class="bg-gray-50 rounded-lg p-4 text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $disciplinary->description }}
                        </div>
                    </div>

                    @if($disciplinary->remarks)
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-2">Administrative Remarks
                            </p>
                            <div
                                class="bg-blue-50 rounded-lg p-4 text-gray-700 leading-relaxed whitespace-pre-line border-l-4 border-blue-400">
                                {{ $disciplinary->remarks }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-master-layout>