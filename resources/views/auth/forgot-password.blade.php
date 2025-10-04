<x-guest-layout>
    <div class="max-w-md mx-auto mt-12 bg-white/80 shadow-2xl rounded-2xl px-8 py-10 border border-blue-100">
        @include('auth._pro-logo')
        <h2 class="text-2xl font-bold text-center text-blue-800 mb-6 tracking-tight">Forgot your password?</h2>
        <div class="mb-4 text-sm text-gray-600 text-center">
            {{ __('No problem. Enter your email and we will email you a password reset link.') }}
        </div>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <x-primary-button class="w-full py-3 text-lg font-bold bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </form>
        <div class="mt-6 text-center text-sm text-gray-600">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">Back to login</a>
        </div>
    </div>
</x-guest-layout>
