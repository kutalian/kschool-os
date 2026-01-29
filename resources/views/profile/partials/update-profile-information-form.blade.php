@php
    /** @var \App\Models\User $user */
@endphp
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex items-center gap-6">
            <div class="relative">
                <img id="profile-preview"
                    src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : asset('assets/images/default-avatar.png') }}"
                    alt="Profile Picture" class="w-24 h-24 rounded-full object-cover border-2 border-gray-200">
                <label for="profile_pic"
                    class="absolute bottom-0 right-0 bg-blue-600 text-white p-1.5 rounded-full cursor-pointer hover:bg-blue-700 transition shadow-sm">
                    <i class="fas fa-camera text-xs"></i>
                </label>
                <input type="file" id="profile_pic" name="profile_pic" class="hidden" accept="image/*"
                    onchange="previewImage(this)">
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-700">Profile Photo</h3>
                <p class="text-xs text-gray-500">Update your profile picture. Recommended: Square, max 2MB.</p>
                <x-input-error class="mt-2" :messages="$errors->get('profile_pic')" />
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @if($staff)
            <div class="border-t border-gray-100 pt-6">
                <h3 class="text-md font-medium text-gray-800 mb-4">Personal Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="phone" :value="__('Phone Number')" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $staff->phone)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>
                    <div>
                        <x-input-label for="gender" :value="__('Gender')" />
                        <select id="gender" name="gender"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="Male" {{ old('gender', $staff->gender) === 'Male' ? 'selected' : '' }}>Male
                            </option>
                            <option value="Female" {{ old('gender', $staff->gender) === 'Female' ? 'selected' : '' }}>Female
                            </option>
                            <option value="Other" {{ old('gender', $staff->gender) === 'Other' ? 'selected' : '' }}>Other
                            </option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                    </div>
                    <div>
                        <x-input-label for="dob" :value="__('Date of Birth')" />
                        <x-text-input id="dob" name="dob" type="date" class="mt-1 block w-full" :value="old('dob', $staff->dob ? $staff->dob->format('Y-m-d') : '')" />
                        <x-input-error class="mt-2" :messages="$errors->get('dob')" />
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6">
                <h3 class="text-md font-medium text-gray-800 mb-4">Address Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="city" :value="__('City')" />
                        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $staff->city)" />
                    </div>
                    <div>
                        <x-input-label for="state" :value="__('State')" />
                        <x-text-input id="state" name="state" type="text" class="mt-1 block w-full" :value="old('state', $staff->state)" />
                    </div>
                    <div>
                        <x-input-label for="country" :value="__('Country')" />
                        <x-text-input id="country" name="country" type="text" class="mt-1 block w-full"
                            :value="old('country', $staff->country)" required />
                    </div>
                    <div class="md:col-span-3">
                        <x-input-label for="current_address" :value="__('Current Address')" />
                        <textarea id="current_address" name="current_address" rows="2"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('current_address', $staff->current_address) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6">
                <h3 class="text-md font-medium text-gray-800 mb-4">Qualification & Professional</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="qualification" :value="__('Qualification')" />
                        <x-text-input id="qualification" name="qualification" type="text" class="mt-1 block w-full"
                            :value="old('qualification', $staff->qualification)" />
                    </div>
                    <div>
                        <x-input-label for="experience_years" :value="__('Experience (Years)')" />
                        <x-text-input id="experience_years" name="experience_years" type="number" class="mt-1 block w-full"
                            :value="old('experience_years', $staff->experience_years)" required />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="university" :value="__('University')" />
                        <x-text-input id="university" name="university" type="text" class="mt-1 block w-full"
                            :value="old('university', $staff->university)" />
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6">
                <h3 class="text-md font-medium text-gray-800 mb-4">Banking Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="bank_name" :value="__('Bank Name')" />
                        <x-text-input id="bank_name" name="bank_name" type="text" class="mt-1 block w-full"
                            :value="old('bank_name', $staff->bank_name)" />
                        <x-input-error class="mt-2" :messages="$errors->get('bank_name')" />
                    </div>
                    <div>
                        <x-input-label for="bank_account_no" :value="__('Account Number')" />
                        <x-text-input id="bank_account_no" name="bank_account_no" type="text" class="mt-1 block w-full"
                            :value="old('bank_account_no', $staff->bank_account_no)" />
                        <x-input-error class="mt-2" :messages="$errors->get('bank_account_no')" />
                    </div>
                    <div>
                        <x-input-label for="bank_code" :value="__('Bank Code / IFSC')" />
                        <x-text-input id="bank_code" name="bank_code" type="text" class="mt-1 block w-full"
                            :value="old('bank_code', $staff->bank_code)" />
                        <x-input-error class="mt-2" :messages="$errors->get('bank_code')" />
                    </div>
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profile-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</section>