<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-900 tracking-tight">
                {{ __('Profile Settings') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-200 min-h-screen">
        <div class="max-w-3xl mx-auto space-y-10">
            <div class="bg-white/90 shadow-xl rounded-2xl p-8 border border-gray-100">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">{{ __('Profile Information') }}</h3>
                @include('profile.partials.update-profile-information-form', ['user' => $user])
            </div>

            <div class="bg-white/90 shadow-xl rounded-2xl p-8 border border-gray-100">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">{{ __('Change Password') }}</h3>
                @include('profile.partials.update-password-form', ['user' => $user])
            </div>

            <div class="bg-white/90 shadow-xl rounded-2xl p-8 border border-red-200">
                <h3 class="text-xl font-semibold text-red-700 mb-6 border-b pb-2">{{ __('Danger Zone') }}</h3>
                @include('profile.partials.delete-user-form', ['user' => $user])
            </div>
        </div>
    </div>
</x-app-layout>
