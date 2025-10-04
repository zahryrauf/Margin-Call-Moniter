<section>
    <header>
        <h2 class="text-lg font-semibold text-gray-900 mb-1">
            {{ __('Update Password') }}
        </h2>
        <p class="text-sm text-gray-600 mb-4">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')
        <div class="grid gap-4 md:grid-cols-2">
            <div class="col-span-2">
                <x-input-label for="update_password_current_password" :value="__('Current Password')" class="font-semibold text-gray-700" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>
            <div class="col-span-2">
                <x-input-label for="update_password_password" :value="__('New Password')" class="font-semibold text-gray-700" />
                <x-text-input id="update_password_password" name="password" type="password" class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>
            <div class="col-span-2">
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="font-semibold text-gray-700" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-2 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>
        <div class="flex items-center gap-4 mt-6">
            <x-primary-button class="px-6 py-2 text-base">{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
