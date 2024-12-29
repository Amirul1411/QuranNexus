<x-dialog-modal id="registerModal" maxWidth="md" wire:model.live="show" darkBg="modal-bg" footerPosition="text-center"
    footerJustify="justify-center" footerItems="items-start" footerPaddingY='pb-4'>

    <x-slot name="title">
        <h2 class="text-center text-3xl my-5 text-white">Register</h2>
    </x-slot>

    <x-slot name="content">
        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="my-7 relative w-full justify-center flex">
                <x-label for="name" value="{{ __('Name') }}" class="hidden"/>
                <x-input rounded="rounded-full" darkBg="" darkText="dark:text-black" id="name"
                    class="block mt-1 z-0 w-full font-semibold pl-12" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" placeholder="Name" />
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 z-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 text-black">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </span>
            </div>

            <div class="my-7 relative w-full justify-center flex">
                <x-label for="email" value="{{ __('Email') }}" class="hidden"/>
                <x-input class="block mt-1 w-full font-semibold pl-12 z-0" rounded="rounded-full" darkBg=""
                    darkText="dark:text-black" id="email" class="block mt-1 w-full font-semibold pl-12 z-0 h-[40px]"
                    type="email" name="email" :value="old('email')" required autocomplete="username"
                    placeholder="E-mail" />
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 z-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 text-black">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                </span>
            </div>

            <div class="my-7 relative w-full justify-center flex" x-data="{ showPassword: false }">
                <x-label for="password" value="{{ __('Password') }}" class="hidden"/>
                <x-input rounded="rounded-full" darkBg="" darkText="dark:text-black" id="password"
                    x-bind:type="showPassword ? 'text' : 'password'" class="block mt-1 w-full font-semibold pl-12 z-0"
                    type="password" name="password" required autocomplete="new-password" placeholder="Password" />
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 z-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 text-black">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                    </svg>
                </span>
                <span class="absolute inset-y-0 right-3 flex items-center pl-3 text-gray-500 z-1">
                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer text-black"
                        @click="showPassword = !showPassword">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer text-black"
                        @click="showPassword = !showPassword">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </span>
            </div>

            <div class="my-7 relative w-full justify-center flex" x-data="{ showPassword: false }">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="hidden"/>
                <x-input rounded="rounded-full" darkBg="" darkText="dark:text-black" id="password_confirmation"
                    x-bind:type="showPassword ? 'text' : 'password'" class="block mt-1 w-full font-semibold pl-12 z-0"
                    type="password" name="password_confirmation" required autocomplete="new-password"
                    placeholder="Confirm Password" />
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 z-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 text-black">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                    </svg>
                </span>
                <span class="absolute inset-y-0 right-3 flex items-center pl-3 text-gray-500 z-1">
                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="size-6 cursor-pointer text-black" @click="showPassword = !showPassword">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer text-black"
                        @click="showPassword = !showPassword">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </span>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox darkBg="" name="terms" id="terms" required />

                            <div class="ms-2 text-gray-400">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                        route('terms.show') .
                                        '" class="text-sm text-[#63FFDA] hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                        __('Terms of Service') .
                                        '</a>',
                                    'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                        route('policy.show') .
                                        '" class="text-sm text-[#63FFDA] hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                        __('Privacy Policy') .
                                        '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-center mt-4">
                <x-button textSize="text-base" tracking="tracking-wide" uppercase="" darkText="text-white"
                    darkBg="dark:bg-black" rounded="rounded-full"
                    class="ms-4 font-sans hover:text-black w-1/2 my-4 justify-center focus:text-black dark:focus:text-black">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <h2 class="text-base text-white font-sans font-semibold me-3">Already have an account?</h2>
        <a @click="$dispatch('render-login-modal')"
            class="cursor-pointer text-base font-sans font-semibold text-[#63FFDA] hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">Login</a>
    </x-slot>
</x-dialog-modal>
