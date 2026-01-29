<x-master-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">General Settings</h1>
            <p class="text-gray-500 mt-1">Manage your school's identity, branding, and localization.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- School Info -->
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">School Information</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                        <div class="space-y-1">
                            <x-input-label for="school_name" :value="__('School Name')" class="font-semibold text-gray-700" />
                            <x-text-input id="school_name" class="block w-full border-gray-200 focus:ring-blue-500 focus:border-blue-500 rounded-xl" type="text" name="school_name"
                                :value="old('school_name', $settings->school_name)" required autofocus />
                            <x-input-error :messages="$errors->get('school_name')" class="mt-2" />
                        </div>
                        <div class="space-y-1">
                            <x-input-label for="school_email" :value="__('School Email')" class="font-semibold text-gray-700" />
                            <x-text-input id="school_email" class="block w-full border-gray-200 focus:ring-blue-500 focus:border-blue-500 rounded-xl" type="email"
                                name="school_email" :value="old('school_email', $settings->school_email)" />
                        </div>
                        <div class="space-y-1">
                            <x-input-label for="school_phone" :value="__('School Phone')" class="font-semibold text-gray-700" />
                            <x-text-input id="school_phone" class="block w-full border-gray-200 focus:ring-blue-500 focus:border-blue-500 rounded-xl" type="text"
                                name="school_phone" :value="old('school_phone', $settings->school_phone)" />
                        </div>
                        <div class="space-y-1">
                            <x-input-label for="school_website" :value="__('Website URL')" class="font-semibold text-gray-700" />
                            <x-text-input id="school_website" class="block w-full border-gray-200 focus:ring-blue-500 focus:border-blue-500 rounded-xl" type="url"
                                name="school_website" :value="old('school_website', $settings->school_website)" />
                        </div>
                        <div class="md:col-span-2 space-y-1">
                            <x-input-label for="school_address" :value="__('Address')" class="font-semibold text-gray-700" />
                            <textarea id="school_address" name="school_address"
                                class="block w-full border-gray-200 focus:ring-blue-500 focus:border-blue-500 rounded-xl shadow-sm"
                                rows="3">{{ old('school_address', $settings->school_address) }}</textarea>
                        </div>
                    </div>

                    <!-- Branding -->
                    <div class="flex items-center gap-3 mb-6 pt-10 border-t border-gray-100">
                        <div class="h-8 w-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center">
                            <i class="fas fa-palette"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Branding</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                            <x-input-label for="logo" :value="__('School Logo')" class="font-semibold text-gray-700 mb-4" />
                            <div class="flex items-start gap-6">
                                <div class="flex-1">
                                    <input id="logo" type="file" name="logo"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition cursor-pointer" />
                                    <p class="text-xs text-gray-400 mt-2">Recommended size: 400x100px. Max 2MB.</p>
                                </div>
                                @if($settings->logo_path)
                                    <div class="bg-white p-2 rounded-lg border border-gray-200 shadow-sm">
                                        <img src="{{ $settings->logo_path }}" alt="Logo" class="h-12 w-auto object-contain">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                            <x-input-label for="favicon" :value="__('Favicon')" class="font-semibold text-gray-700 mb-4" />
                            <div class="flex items-start gap-6">
                                <div class="flex-1">
                                    <input id="favicon" type="file" name="favicon"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition cursor-pointer" />
                                    <p class="text-xs text-gray-400 mt-2">Recommended: 64x64px ICO or PNG.</p>
                                </div>
                                @if($settings->favicon_path)
                                    <div class="bg-white p-2 rounded-lg border border-gray-200 shadow-sm">
                                        <img src="{{ $settings->favicon_path }}" alt="Favicon" class="h-8 w-8 object-contain">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="md:col-span-2 space-y-2">
                            <x-input-label for="theme_color" :value="__('Primary Theme Color')" class="font-semibold text-gray-700" />
                            <div class="flex items-center gap-4">
                                <input type="color" id="theme_color_picker" 
                                    value="{{ old('theme_color', $settings->theme_color ?? '#3B82F6') }}"
                                    class="h-12 w-12 border-none rounded-xl cursor-pointer p-0 overflow-hidden"
                                    oninput="document.getElementById('theme_color').value = this.value">
                                <x-text-input type="text" id="theme_color" name="theme_color" 
                                    :value="old('theme_color', $settings->theme_color ?? '#3B82F6')" 
                                    class="block w-32 border-gray-200 focus:ring-blue-500 focus:border-blue-500 rounded-xl" />
                            </div>
                        </div>
                    <!-- Localization -->
                    <div class="flex items-center gap-3 mb-6 pt-10 border-t border-gray-100">
                        <div class="h-8 w-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Localization</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                        <div class="space-y-1">
                            <x-input-label for="timezone" :value="__('System Timezone')" class="font-semibold text-gray-700" />
                            <select id="timezone" name="timezone" class="block w-full border-gray-200 focus:ring-blue-500 focus:border-blue-500 rounded-xl shadow-sm">
                                @foreach($timezones as $region => $list)
                                    <optgroup label="{{ $region }}">
                                        @foreach($list as $tz)
                                            <option value="{{ $tz }}" {{ old('timezone', $settings->timezone) == $tz ? 'selected' : '' }}>
                                                {{ str_replace('_', ' ', explode('/', $tz)[1] ?? $tz) }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('timezone')" class="mt-2" />
                        </div>
                        <div class="space-y-1">
                            <x-input-label for="date_format" :value="__('Date Format')" class="font-semibold text-gray-700" />
                            <select id="date_format" name="date_format" class="block w-full border-gray-200 focus:ring-blue-500 focus:border-blue-500 rounded-xl shadow-sm">
                                <option value="F j, Y" {{ old('date_format', $settings->date_format) == 'F j, Y' ? 'selected' : '' }}>January 29, 2026</option>
                                <option value="Y-m-d" {{ old('date_format', $settings->date_format) == 'Y-m-d' ? 'selected' : '' }}>2026-01-29</option>
                                <option value="d/m/Y" {{ old('date_format', $settings->date_format) == 'd/m/Y' ? 'selected' : '' }}>29/01/2026</option>
                                <option value="m/d/Y" {{ old('date_format', $settings->date_format) == 'm/d/Y' ? 'selected' : '' }}>01/29/2026</option>
                            </select>
                            <x-input-error :messages="$errors->get('date_format')" class="mt-2" />
                        </div>
                    </div>
                </div>

                    <div class="flex items-center justify-end mt-12 bg-gray-50 -mx-8 -mb-8 p-6 border-t border-gray-100">
                        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-master-layout>