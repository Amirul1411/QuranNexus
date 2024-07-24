<div class="flex space-x-5">
    <x-nav-link class="{{ Route::is('home') ? 'text-white' : 'text-black' }}" href="{{ route('login') }}" :active="request()->routeIs('login')">
        {{ __('menu.login') }}
    </x-nav-link>
    <x-nav-link class="{{ Route::is('home') ? 'text-white' : 'text-black' }}" href="{{ route('register') }}" :active="request()->routeIs('register')">
        {{ __('menu.register') }}
    </x-nav-link>
</div>
