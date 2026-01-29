<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Request Account Deletion') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('If you wish to delete your account, please submit a request for review. Once approved by an administrator, your account and all associated data will be permanently removed.') }}
        </p>
    </header>

    @if(auth()->user()->isDeletionPending())
        <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-center gap-3 text-amber-700">
            <i class="fas fa-clock"></i>
            <span class="text-sm font-medium">Your account deletion request is currently pending administrator
                approval.</span>
        </div>
    @else
        <x-danger-button x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Request Account Deletion') }}</x-danger-button>
    @endif

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to request account deletion?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Your request will be sent to the school administration for final approval. Please provide a reason for your request and enter your password to confirm.') }}
            </p>

            <div class="mt-6 space-y-4">
                <div>
                    <x-input-label for="reason" value="{{ __('Reason for deletion (Optional)') }}" />
                    <textarea id="reason" name="reason"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        rows="3" placeholder="Why would you like to delete your account?"></textarea>
                    <x-input-error :messages="$errors->userDeletion->get('reason')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                        placeholder="{{ __('Confirm with Password') }}" />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Submit Request') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>