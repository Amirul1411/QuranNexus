<div class="flex space-x-5">
    <x-nav-link class="{{ Route::is('home') ? 'text-white' : 'text-black' }} cursor-pointer" @click="$dispatch('render-login-modal')">
        {{ __('menu.login') }}
    </x-nav-link>
    <x-nav-link class="{{ Route::is('home') ? 'text-white' : 'text-black' }} cursor-pointer" @click="$dispatch('render-register-modal')">
        {{ __('menu.register') }}
    </x-nav-link>
</div>
