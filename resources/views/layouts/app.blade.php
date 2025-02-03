@props(['title', 'backgroundImage' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ isset($title) ? $title . ' | ' : '' }}{{ config('app.name', '') }}</title>
    <link rel="icon" type="image/png" href="{{ Storage::url('web-images/quran-nexus-logo-image.png') }}">

    <!-- Styles -->
    @livewireStyles
    @filamentStyles

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/scss/app.scss'])

</head>

<body
    class="font-sans antialiased {{ !Route::is('home') && !Route::is('contact') && !Route::is('faqs') && !Route::is('login') && !Route::is('password.reset') && !Route::is('password.request') && !Route::is('register') && !Route::is('verification.notice') && !Route::is('terms.show') && !Route::is('policy.show') ? 'background' : 'bg-gray-100' }}">
    <x-banner />

    @include('layouts.partials.header')

    {{-- <div x-data="{ showLogin: false, showRegister: false, showForgotPassword: false }" x-init="showLogin = false;
    showRegister = false"
        x-on:render-login-modal.window="showRegister=false; showForgotPassword=false; await $nextTick(); showLogin=true;  await $nextTick(); $dispatch('openLoginModal');"
        x-on:render-register-modal.window="showLogin=false; showForgotPassword=false; await $nextTick(); showRegister=true;  await $nextTick(); $dispatch('openRegisterModal');"
        x-on:render-forgot-password-modal.window="showRegister=false; showLogin=false; await $nextTick(); showForgotPassword=true;  await $nextTick(); $dispatch('openForgotPasswordModal');">

        <!-- Login Modal -->
        <template x-if="showLogin">
            <div>
                @livewire('auth.login-modal')
            </div>
        </template>

        <!-- Register Modal -->
        <template x-if="showRegister">
            <div>
                @livewire('auth.register-modal')
            </div>
        </template>

        <!-- Forgot Password Modal -->
        <template x-if="showForgotPassword">
            <div>
                @livewire('auth.forgot-password-modal')
            </div>
        </template>
    </div> --}}

    {{-- <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
        </div> --}}

    @livewire('notifications')

    <!-- Page Heading -->
    @if (isset($header))
        <header>
            {{ $header }}
        </header>
    @endif

    <!-- Page Content -->
    <main class=" {{ $backgroundImage }} container flex flex-grow mx-auto">

        <!-- Left Side Menu -->
        @if (isset($leftSideMenu))
            {{ $leftSideMenu }}
        @endif

        {{ $slot }}

        <!-- Settings Right Side Menu -->
        @livewire('settings-side-menu')

    </main>

    @include('layouts.partials.footer')

    @stack('modals')
    @stack('scripts')
    @livewireScripts
    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>
