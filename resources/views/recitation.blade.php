<x-app-layout title="Recitation">

    @if (Auth::user() && Route::is('surah.show'))
        @livewire('recently_read', ['type' => 'surah', 'itemId' => $surah->id])
    @elseif(Auth::user() && Route::is('page.show'))
        @livewire('recently_read', ['type' => 'page', 'itemId' => $page->id])
    @elseif(Auth::user() && Route::is('juz.show'))
        @livewire('recently_read', ['type' => 'juz', 'itemId' => $juz->id])
    @endif

    @if (Auth::user())
        @livewire('recitation-timer')
    @endif

    <x-slot name="sideMenu">
        @livewire('recitation-side-menu')
    </x-slot>

    <div class="w-full mx-32">
        <div class="flex justify-center my-3 mt-32">
            <div x-data="{ activeOption: 'byAyat' }" class="bg-black rounded-full flex my-5">
                <input type="radio" class="hidden" name="recitationPageLayoutOptions" id="byAyat" autocomplete="off"
                    checked x-model="activeOption" value="byAyat">
                <label :class="activeOption === 'byAyat' ? 'bg-gray-600' : 'bg-transparent'"
                    class="hover:bg-gray-500 rounded-full px-10 cursor-pointer py-2 text-white font-serif flex items-center"
                    for="byAyat" @click="$dispatch('set-page-layout', 'byAyah')"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    {{ __('recitation.ayat_by_ayat') }}</label>

                <input type="radio" class="hidden" name="recitationPageLayoutOptions" id="byPage"
                    autocomplete="off" x-model="activeOption" value="byPage">
                <label :class="activeOption === 'byPage' ? 'bg-gray-600' : 'bg-transparent'"
                    class="hover:bg-gray-500 rounded-full px-10 py-2 cursor-pointer text-white font-serif flex items-center"
                    for="byPage" @click="$dispatch('set-page-layout', 'byPage')"><svg
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2">
                        <path
                            d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                        <path
                            d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                    </svg>
                    {{ __('recitation.page_by_page') }}</label>
            </div>
        </div>

        <div x-data="{ layout: 'byAyah' }" @set-page-layout.window="layout = $event.detail">
            <template x-if=" layout === 'byAyah' ">
                @if (Route::is('surah.show'))
                    <h3 class="text-center text-white font-light text-9xl mt-6 font-surahnames">
                        {{ mapSurahNumberToSurahFont($surah->id) }}</h3>
                @endif
            </template>
        </div>

        @if (Route::is('surah.show'))
            <div class="flex justify-end items-center my-5">

                @livewire('surah-info-button', ['surah' => $surah])

            </div>
            @if (Route::is('surah.show'))
                @livewire('audio-recitation-button', ['surah' => $surah])
            @elseif (Route::is('page.show'))
                @livewire('audio-recitation-button', ['page' => $page])
            @elseif (Route::is('juz.show'))
                @livewire('audio-recitation-button', ['juz' => $juz])
            @endif

        @endif

        <div class="flex justify-end mr-1 text-white">
            @if (Route::is('surah.show'))
                @livewire('bookmark', ['type' => 'surah', 'itemId' => $surah->id])
            @elseif(Route::is('page.show'))
                @livewire('bookmark', ['type' => 'page', 'itemId' => $page->id])
            @endif
        </div>



        <div x-data="{ layout: 'byAyah' }" @set-page-layout.window="layout = $event.detail" class="h-auto">
            <template x-if=" layout === 'byAyah' ">
                @if (Route::is('surah.show'))
                    @livewire('recitation-by-ayah', ['surah' => $surah])
                @elseif (Route::is('page.show'))
                    @livewire('recitation-by-ayah', ['page' => $page])
                @elseif (Route::is('juz.show'))
                    @livewire('recitation-by-ayah', ['juz' => $juz])
                @endif
            </template>
            <template x-if=" layout === 'byPage' ">
                @if (Route::is('surah.show'))
                    @livewire('recitation-by-page', ['page' => $surah->ayahs->first()->page])
                @elseif(Route::is('page.show'))
                    @livewire('recitation-by-page', ['page' => $page])
                @elseif (Route::is('juz.show'))
                    @livewire('recitation-by-page', ['page' => $juz->ayahs->first()->page])
                @endif
            </template>
        </div>
    </div>
</x-app-layout>
