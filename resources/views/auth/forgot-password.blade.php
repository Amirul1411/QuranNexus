{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}

<x-app-layout title="Forgot Password" backgroundImage="background-image">
    <div class="w-full my-4">
        <x-authentication-card background="bg-transparent">
            <x-slot name="logo">
                {{-- <x-authentication-card-logo /> --}}
            </x-slot>

            <h2 class="text-center text-3xl my-5 text-black font-medium">Forgot Password</h2>

            <div class="mb-4 text-sm text-black dark:text-gray-400 font-semibold">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            @session('status')
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ $value }}
                </div>
            @endsession

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="my-7 relative w-full justify-center flex">
                    <x-label for="email" value="{{ __('Email') }}" class="hidden" />
                    {{-- <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" /> --}}
                    <x-input rounded="rounded-full" darkBg="" darkText="dark:text-black" id="email"
                        class="block mt-1 z-0 w-full font-semibold pl-12" type="email" name="email" :value="old('email')"
                        required autofocus autocomplete="username" placeholder="E-mail" />
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 z-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6 text-black">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                    </span>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <x-button textSize="text-base" tracking="tracking-wide" uppercase="" darkText="text-white"
                    darkBg="dark:bg-black" rounded="rounded-full"
                    class="ms-4 font-sans hover:text-black w-3/4 my-4 justify-center focus:text-black dark:focus:text-black">
                        {{ __('Email Password Reset Link') }}
                    </x-button>
                </div>
            </form>
        </x-authentication-card>
    </div>
</x-app-layout>
