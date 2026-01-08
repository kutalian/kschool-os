<x-master-layout>
    <div class="container mx-auto px-4 py-6">
        
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex justify-between items-center">
            <div class="flex items-center">
                <div class="h-20 w-20 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-3xl font-bold mr-6">
                    {{ substr($parent->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $parent->name }}</h1>
                    <p class="text-gray-500 mt-1">
                        <span class="mr-4"><i class="fas fa-envelope mr-2"></i>{{ $parent->email }}</span>
                        <span><i class="fas fa-phone mr-2"></i>{{ $parent->phone ?? $parent->primary_phone }}</span>
                    </p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('parents.edit', $parent->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-edit mr-2"></i> Edit Profile
                </a>
                <a href="{{ route('parents.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Column: Contact & Family Info -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Contact Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Contact Details</h3>
                    <div class="space-y-3">
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Primary Phone</span> {{ $parent->primary_phone }}</p>
                        @if($parent->phone)
                            <p class="text-sm"><span class="block text-gray-400 text-xs">Secondary Phone</span> {{ $parent->phone }}</p>
                        @endif
                        <p class="text-sm"><span class="block text-gray-400 text-xs">Address</span> {{ $parent->address ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Family Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Family Information</h3>
                    
                    @if($parent->father_name)
                        <div class="mb-4">
                            <h4 class="font-semibold text-gray-700">Father</h4>
                            <p class="text-sm text-gray-600">{{ $parent->father_name }}</p>
                            <p class="text-xs text-gray-400">{{ $parent->father_phone }} | {{ $parent->father_occupation }}</p>
                        </div>
                    @endif

                    @if($parent->mother_name)
                        <div class="mb-4">
                            <h4 class="font-semibold text-gray-700">Mother</h4>
                            <p class="text-sm text-gray-600">{{ $parent->mother_name }}</p>
                            <p class="text-xs text-gray-400">{{ $parent->mother_phone }} | {{ $parent->mother_occupation }}</p>
                        </div>
                    @endif

                    @if($parent->guardian_name)
                        <div>
                            <h4 class="font-semibold text-gray-700">Guardian ({{ $parent->guardian_relation }})</h4>
                            <p class="text-sm text-gray-600">{{ $parent->guardian_name }}</p>
                            <p class="text-xs text-gray-400">{{ $parent->guardian_phone }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Linked Children -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Children List -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-users text-blue-500 mr-2"></i> Children (Students)
                        <span class="ml-2 bg-blue-100 text-blue-800 text-xs py-1 px-2 rounded-full">{{ $parent->students->count() }}</span>
                    </h3>
                    
                    @if($parent->students->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($parent->students as $student)
                                <div class="border rounded-lg p-4 flex items-center hover:shadow-md transition">
                                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mr-4">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-bold text-gray-800">{{ $student->name }}</h4>
                                        <p class="text-sm text-gray-500">Class: {{ $student->class_room->name ?? 'N/A' }} | Roll: {{ $student->roll_no ?? '-' }}</p>
                                        <p class="text-xs text-gray-400">Adm No: {{ $student->admission_no }}</p>
                                    </div>
                                    <a href="{{ route('students.show', $student->id) }}" class="text-blue-500 hover:text-blue-700 bg-blue-50 p-2 rounded-full">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-child text-4xl mb-3"></i>
                            <p>No children linked to this parent profile.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-master-layout>
