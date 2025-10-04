<x-guest-layout>
    <div class="max-w-md mx-auto mt-12 bg-white/80 shadow-2xl rounded-2xl px-8 py-10 border border-blue-100">
        @include('auth._pro-logo')
        <h2 class="text-2xl font-bold text-center text-blue-800 mb-6 tracking-tight">Verify your email address</h2>
        <div class="mb-4 text-sm text-gray-600 text-center">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600 text-center">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif
        <div class="mt-4 flex flex-col gap-3 items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                @csrf
                <x-primary-button class="w-full py-3 text-lg font-bold bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </form>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full py-3 text-lg font-bold rounded-lg bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700 hover:from-gray-300 hover:to-gray-400 hover:text-gray-900 transition-all duration-200 mt-2">{{ __('Log Out') }}</button>
            </form>
        </div>
    </div>
</x-guest-layout>
