@props(['title', 'backgroundImage' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ isset($title) ? $title . ' | ' : '' }}{{ config('app.name', '') }}</title>
    <link rel="icon" type="image/png" href="{{ Vite::asset('resources/images/quran-nexus-logo-image.png') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

</head>

<body
    class="font-sans antialiased {{ !Route::is('home') && !Route::is('contact') && !Route::is('faqs') ? 'background' : 'bg-gray-100' }}">
    <x-banner />

    @include('layouts.partials.header')
    {{-- @include('auth.login') --}}
    {{-- @include('auth.register') --}}

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

    <!-- Page Heading -->
    @if (isset($header))
        <header>
            {{ $header }}
        </header>
    @endif

    <!-- Page Content -->
    <main class=" {{ $backgroundImage }} container flex flex-grow mx-auto">
        <!-- Side Menu -->
        @if (isset($sideMenu))
            {{ $sideMenu }}
        @endif
        {{ $slot }}
    </main>

    @include('layouts.partials.footer')

    @stack('modals')
    @livewireScripts
</body>

</html>
