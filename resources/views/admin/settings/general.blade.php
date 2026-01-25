<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('General Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- School Info -->
                        <h3 class="text-lg font-medium text-gray-900 mb-4">School Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <x-input-label for="school_name" :value="__('School Name')" />
                                <x-text-input id="school_name" class="block mt-1 w-full" type="text" name="school_name"
                                    :value="old('school_name', $settings->school_name)" required autofocus />
                                <x-input-error :messages="$errors->get('school_name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="school_email" :value="__('School Email')" />
                                <x-text-input id="school_email" class="block mt-1 w-full" type="email"
                                    name="school_email" :value="old('school_email', $settings->school_email)" />
                            </div>
                            <div>
                                <x-input-label for="school_phone" :value="__('School Phone')" />
                                <x-text-input id="school_phone" class="block mt-1 w-full" type="text"
                                    name="school_phone" :value="old('school_phone', $settings->school_phone)" />
                            </div>
                            <div>
                                <x-input-label for="school_website" :value="__('Website URL')" />
                                <x-text-input id="school_website" class="block mt-1 w-full" type="url"
                                    name="school_website" :value="old('school_website', $settings->school_website)" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="school_address" :value="__('Address')" />
                                <textarea id="school_address" name="school_address"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    rows="3">{{ old('school_address', $settings->school_address) }}</textarea>
                            </div>
                        </div>

                        <!-- Branding -->
                        <h3 class="text-lg font-medium text-gray-900 mb-4 pt-6 border-t">Branding</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <x-input-label for="logo" :value="__('School Logo')" />
                                <input id="logo" type="file" name="logo"
                                    class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                @if($settings->logo_path)
                                    <div class="mt-2">
                                        <img src="{{ $settings->logo_path }}" alt="Logo" class="h-16 w-auto object-contain">
                                    </div>
                                @endif
                            </div>
                            <div>
                                <x-input-label for="favicon" :value="__('Favicon')" />
                                <input id="favicon" type="file" name="favicon"
                                    class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                @if($settings->favicon_path)
                                    <div class="mt-2">
                                        <img src="{{ $settings->favicon_path }}" alt="Favicon"
                                            class="h-8 w-8 object-contain">
                                    </div>
                                @endif
                            </div>
                            <div>
                                <x-input-label for="theme_color" :value="__('Theme Color')" />
                                <div class="flex items-center gap-2 mt-1">
                                    <input type="color" id="theme_color" name="theme_color"
                                        value="{{ old('theme_color', $settings->theme_color) }}"
                                        class="h-10 w-10 border rounded cursor-pointer">
                                    <x-text-input type="text" name="theme_color" :value="old('theme_color', $settings->theme_color)" class="block w-full" />
                                </div>
                            </div>
                        </div>

                        <!-- Localization -->
                        <h3 class="text-lg font-medium text-gray-900 mb-4 pt-6 border-t">Localization</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <x-input-label for="currency_code" :value="__('Currency Code')" />
                                <x-text-input id="currency_code" class="block mt-1 w-full" type="text"
                                    name="currency_code" :value="old('currency_code', $settings->currency_code)" />
                            </div>
                            <div>
                                <x-input-label for="currency_symbol" :value="__('Currency Symbol')" />
                                <x-text-input id="currency_symbol" class="block mt-1 w-full" type="text"
                                    name="currency_symbol" :value="old('currency_symbol', $settings->currency_symbol)" />
                            </div>
                            <div>
                                <x-input-label for="timezone" :value="__('Timezone')" />
                                <select id="timezone" name="timezone"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach(timezone_identifiers_list() as $timezone)
                                        <option value="{{ $timezone }}" {{ $settings->timezone == $timezone ? 'selected' : '' }}>{{ $timezone }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <h3 class="text-lg font-medium text-gray-900 mb-4 pt-6 border-t">Social Media</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            @php $socials = $settings->social_links ?? []; @endphp
                            <div>
                                <x-input-label for="social_facebook" :value="__('Facebook URL')" />
                                <x-text-input id="social_facebook" class="block mt-1 w-full" type="url"
                                    name="social_links[facebook]" :value="$socials['facebook'] ?? ''" />
                            </div>
                            <div>
                                <x-input-label for="social_twitter" :value="__('Twitter URL')" />
                                <x-text-input id="social_twitter" class="block mt-1 w-full" type="url"
                                    name="social_links[twitter]" :value="$socials['twitter'] ?? ''" />
                            </div>
                            <div>
                                <x-input-label for="social_instagram" :value="__('Instagram URL')" />
                                <x-text-input id="social_instagram" class="block mt-1 w-full" type="url"
                                    name="social_links[instagram]" :value="$socials['instagram'] ?? ''" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Save Settings') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>