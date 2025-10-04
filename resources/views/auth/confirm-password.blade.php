<x-guest-layout>
    <div class="max-w-md mx-auto mt-12 bg-white/80 shadow-2xl rounded-2xl px-8 py-10 border border-blue-100">
        @include('auth._pro-logo')
        <h2 class="text-2xl font-bold text-center text-blue-800 mb-6 tracking-tight">Confirm your password</h2>
        <div class="mb-4 text-sm text-gray-600 text-center">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>
        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
            @csrf
            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <x-primary-button class="w-full py-3 text-lg font-bold bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700">
                {{ __('Confirm') }}
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>
