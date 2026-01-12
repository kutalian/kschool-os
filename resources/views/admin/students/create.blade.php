<x-master-layout>
    @php
        /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\ClassRoom> $classes */
        /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\StudentParent> $parents */
    @endphp
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">New Student Admission</h1>
        <p class="text-gray-500">Enter student details and parent information.</p>
    </div>

    <form action="{{ route('students.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- 1. Academic Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Academic Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Class -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Class <span
                            class="text-red-500">*</span></label>
                    <select name="class_id" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} - {{ $class->section }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Roll No -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Roll No</label>
                    <input type="text" name="roll_no" value="{{ old('roll_no') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
            </div>
        </div>

        <!-- 2. Personal Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Personal Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- First Name -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">First Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Last Name -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Last Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Email -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email (Optional)</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- DOB -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Date of Birth <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="dob" value="{{ old('dob') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('dob') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Gender -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Gender <span
                            class="text-red-500">*</span></label>
                    <select name="gender" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <!-- Blood Group -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Blood Group</label>
                    <select name="blood_group"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                        <option value="">Select</option>
                        <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                        <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                    </select>
                </div>
                <!-- Nationality -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nationality <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nationality" value="{{ old('nationality', 'Nigerian') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <!-- Religion -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Religion</label>
                    <input type="text" name="religion" value="{{ old('religion') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <!-- Category -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                    <input type="text" name="category" value="{{ old('category') }}"
                        placeholder="e.g. General, Staff Child"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
            </div>
        </div>

        <!-- 3. Contact & Address -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Address & Contact</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">City</label>
                    <input type="text" name="city" value="{{ old('city') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">State</label>
                    <input type="text" name="state" value="{{ old('state') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Country <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="country" value="{{ old('country', 'Nigeria') }}" required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Current Address</label>
                    <textarea name="current_address" rows="2"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">{{ old('current_address') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Permanent Address</label>
                    <textarea name="permanent_address" rows="2"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">{{ old('permanent_address') }}</textarea>
                </div>
            </div>
        </div>

        <!-- 4. Emergency & Medical -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Emergency & Medical</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Emergency Contact Name</label>
                    <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Emergency Contact Number</label>
                    <input type="text" name="emergency_contact_number" value="{{ old('emergency_contact_number') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Allergies</label>
                    <textarea name="allergies" rows="2"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">{{ old('allergies') }}</textarea>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Medications</label>
                    <textarea name="medications" rows="2"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">{{ old('medications') }}</textarea>
                </div>
            </div>
        </div>

        <!-- 5. Previous School Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Previous School Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">School Name</label>
                    <input type="text" name="prev_school_name" value="{{ old('prev_school_name') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">TC Number</label>
                    <input type="text" name="prev_school_tc_no" value="{{ old('prev_school_tc_no') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                </div>
            </div>
        </div>

        <!-- 6. Parent Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6"
            x-data="{ parentChoice: '{{ old('parent_choice', 'new') }}' }">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Parent/Guardian Information</h2>

            <div class="mb-6 flex gap-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="parent_choice" value="new" x-model="parentChoice"
                        class="form-radio text-blue-600">
                    <span class="ml-2">Create New Parent</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="parent_choice" value="existing" x-model="parentChoice"
                        class="form-radio text-blue-600">
                    <span class="ml-2">Select Existing Parent</span>
                </label>
            </div>

            <!-- New Parent Form -->
            <div x-show="parentChoice === 'new'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Parent Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="parent_name" value="{{ old('parent_name') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('parent_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Parent Email <span
                            class="text-red-500">*</span></label>
                    <input type="email" name="parent_email" value="{{ old('parent_email') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('parent_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Parent Phone <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="parent_phone" value="{{ old('parent_phone') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
                    @error('parent_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Existing Parent Select -->
            <div x-show="parentChoice === 'existing'" class="hidden" :class="{'hidden': parentChoice !== 'existing'}">
                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 mb-6">
                    <p class="text-blue-800 text-sm flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-600"></i>
                        Search for a parent by name, email, or phone number.
                    </p>
                </div>

                <div x-data="{
                    search: '',
                    isOpen: false,
                    selectedParent: null,
                    parents: {{ $parents->map(function ($p) {
    return ['id' => $p->id, 'name' => $p->name, 'phone' => $p->phone, 'email' => $p->email];
})->toJson() }},
                    
                    get filteredParents() {
                        if (this.search === '') {
                            return this.parents.slice(0, 10);
                        }
                        return this.parents.filter(parent => {
                            return parent.name.toLowerCase().includes(this.search.toLowerCase()) ||
                                   (parent.email && parent.email.toLowerCase().includes(this.search.toLowerCase())) ||
                                   (parent.phone && parent.phone.includes(this.search));
                        }).slice(0, 10);
                    },

                    selectParent(parent) {
                        this.selectedParent = parent;
                        this.search = '';
                        this.isOpen = false;
                    }
                }" class="relative">

                    <label class="block text-gray-700 text-sm font-bold mb-2">Search Parent</label>
                    <input type="hidden" name="parent_id" :value="selectedParent ? selectedParent.id : ''">

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" x-model="search" @focus="isOpen = true" @click.away="isOpen = false"
                            placeholder="Type name, email or phone..."
                            class="w-full pl-10 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition"
                            autocomplete="off">

                        <!-- Selected Badge -->
                        <template x-if="selectedParent">
                            <div
                                class="absolute right-2 top-2 bottom-2 bg-blue-100 text-blue-800 px-3 flex items-center rounded-md border border-blue-200">
                                <span x-text="selectedParent.name" class="text-sm font-medium mr-2"></span>
                                <button type="button" @click="selectedParent = null; search = ''"
                                    class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </template>
                    </div>

                    <!-- Dropdown -->
                    <div x-show="isOpen && filteredParents.length > 0"
                        class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto"
                        style="display: none;">
                        <template x-for="parent in filteredParents" :key="parent.id">
                            <div @click="selectParent(parent)"
                                class="p-3 hover:bg-gray-50 cursor-pointer border-b border-gray-50 last:border-0 transition">
                                <div class="font-medium text-gray-800" x-text="parent.name"></div>
                                <div class="text-xs text-gray-500 flex gap-3 mt-1">
                                    <span x-show="parent.phone"><i class="fas fa-phone mr-1"></i><span
                                            x-text="parent.phone"></span></span>
                                    <span x-show="parent.email"><i class="fas fa-envelope mr-1"></i><span
                                            x-text="parent.email"></span></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div x-show="isOpen && filteredParents.length === 0"
                        class="absolute z-10 w-full mt-1 bg-white p-4 text-center text-gray-500 border border-gray-200 rounded-lg shadow-lg"
                        style="display: none;">
                        No parents found.
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pb-8">
            <a href="{{ route('students.index') }}"
                class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition font-medium">Cancel</a>
            <button type="submit"
                class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium shadow-sm">Submit
                Admission</button>
        </div>
    </form>
</x-master-layout>