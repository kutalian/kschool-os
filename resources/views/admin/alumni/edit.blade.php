<x-master-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Alumni: {{ $alumni->name }}</h1>
        <a href="{{ route('alumni.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6 max-w-4xl mx-auto">
        <form action="{{ route('alumni.update', $alumni->id) }}" method="POST">
            @csrf
            @method('PUT')

            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Personal Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $alumni->name) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $alumni->email) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $alumni->phone) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="linkedin_url" class="block text-sm font-medium text-gray-700">LinkedIn URL</label>
                    <input type="url" name="linkedin_url" id="linkedin_url"
                        value="{{ old('linkedin_url', $alumni->linkedin_url) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea name="address" id="address" rows="2"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('address', $alumni->address) }}</textarea>
                </div>
            </div>

            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Academic & Professional</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="graduation_year" class="block text-sm font-medium text-gray-700">Graduation Year <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="graduation_year" id="graduation_year"
                        value="{{ old('graduation_year', $alumni->graduation_year) }}" min="1950"
                        max="{{ date('Y') + 1 }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                </div>
                <div>
                    <label for="graduation_class" class="block text-sm font-medium text-gray-700">Graduation
                        Class</label>
                    <input type="text" name="graduation_class" id="graduation_class"
                        value="{{ old('graduation_class', $alumni->graduation_class) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="current_occupation" class="block text-sm font-medium text-gray-700">Current
                        Occupation</label>
                    <input type="text" name="current_occupation" id="current_occupation"
                        value="{{ old('current_occupation', $alumni->current_occupation) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700">Company /
                        Organization</label>
                    <input type="text" name="company_name" id="company_name"
                        value="{{ old('company_name', $alumni->company_name) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="md:col-span-2">
                    <label for="achievements" class="block text-sm font-medium text-gray-700">Notable
                        Achievements</label>
                    <textarea name="achievements" id="achievements" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('achievements', $alumni->achievements) }}</textarea>
                </div>
            </div>

            <div class="mb-6 space-y-2">
                <div class="flex items-center">
                    <input id="willing_to_mentor" name="willing_to_mentor" type="checkbox" value="1" {{ old('willing_to_mentor', $alumni->willing_to_mentor) ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="willing_to_mentor" class="ml-2 block text-sm text-gray-900">
                        Willing to mentor current students?
                    </label>
                </div>
                <div class="flex items-center">
                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $alumni->is_active) ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Active Profile
                    </label>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Update Record
                </button>
            </div>
        </form>
    </div>
</x-master-layout>