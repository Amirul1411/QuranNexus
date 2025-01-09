<x-app-layout title="Profile Page">
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-black dark:text-gray-200 leading-tight mt-40 ms-10 px-8">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <div>
        <div class="mx-7 py-10 sm:px-6 lg:px-8 w-full">

            <div class="mb-10 h-auto w-5/6 mx-auto justify-center">
                @livewire('user-recitation-widget')
            </div>

            <div class="mb-10 h-auto w-5/6 mx-auto">
                @livewire('recitation-time-per-day-widget')
            </div>

            <x-section-border />

            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                {{-- <x-section-border /> --}}
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            {{-- <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div> --}}

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
