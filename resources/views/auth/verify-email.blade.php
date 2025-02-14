{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button type="submit">
                        {{ __('Resend Verification Email') }}
                    </x-button>
                </div>
            </form>

            <div>
                <a
                    href="{{ route('profile.show') }}"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    {{ __('Edit Profile') }}</a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf

                    <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 ms-2">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout> --}}

<x-app-layout title="Reset Password" backgroundImage="background-image">
    <div class="w-full my-4">
        <x-authentication-card background="bg-transparent">
            <x-slot name="logo">
                {{-- <x-authentication-card-logo /> --}}
            </x-slot>

            <div class="mb-4 text-sm text-black dark:text-gray-400 font-semibold">
                {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                </div>
            @endif

            <div class="mt-4 flex items-center justify-center">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div>
                        <x-button textSize="text-base" tracking="tracking-wide" uppercase="" darkText="text-white"
                        darkBg="dark:bg-black" rounded="rounded-full" class="font-sans hover:text-black my-4 justify-center focus:text-black dark:focus:text-black" type="submit">
                            {{ __('Resend Verification Email') }}
                        </x-button>
                    </div>
                </form>

                {{-- <div>
                    <a href="{{ route('profile.show') }}"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Edit Profile') }}</a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf

                        <button type="submit"
                            class="ms-2 text-sm text-[#63FFDA] dark:text-[#63FFDA] font-semibold">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div> --}}
            </div>
        </x-authentication-card>
    </div>
</x-app-layout>
