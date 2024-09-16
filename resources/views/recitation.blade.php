<x-app-layout title="Recitation">

    <x-slot name="sideMenu">
        @livewire('recitation-side-menu')
    </x-slot>

    <div class="w-full mx-32">
        <div class="flex justify-center my-3 mt-32">
            <div x-data="{ activeOption: 'byAyat' }" class="bg-black rounded-full flex my-5">
                <input type="radio" class="hidden" name="recitationPageLayoutOptions" id="byAyat" autocomplete="off" checked
                    x-model="activeOption" value="byAyat">
                <label :class="activeOption === 'byAyat' ? 'bg-gray-600' : 'bg-transparent'"
                    class="hover:bg-gray-500 rounded-full px-10 cursor-pointer py-2 text-white font-serif flex items-center"
                    for="byAyat" @click="$dispatch('set-page-layout', 'byAyah')"><svg xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    Ayat By Ayat</label>

                <input type="radio" class="hidden" name="recitationPageLayoutOptions" id="byPage" autocomplete="off"
                    x-model="activeOption" value="byPage">
                <label :class="activeOption === 'byPage' ? 'bg-gray-600' : 'bg-transparent'"
                    class="hover:bg-gray-500 rounded-full px-10 py-2 cursor-pointer text-white font-serif flex items-center"
                    for="byPage" @click="$dispatch('set-page-layout', 'byPage')"><svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2">
                        <path
                            d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                        <path
                            d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                    </svg>
                    Page By Page</label>
            </div>
        </div>

        <div x-data="{ layout: 'byAyah' }" @set-page-layout.window="layout = $event.detail">
            <template x-if=" layout === 'byAyah' ">
                @if (Route::is('surah.show'))
                    <h3 class="text-center text-white font-light text-9xl mt-6 font-surahnames">{{mapSurahNumberToSurahFont($surah->id)}}</h3>
                @endif
            </template>
        </div>

        @if (Route::is('surah.show'))
            <div class="flex justify-end items-center my-5">
                <span wire:click="displaySurahDetails({{ $surah->_id }})" class="mr-1 text-white cursor-pointer"><svg
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
                <p wire:click="displaySurahDetails({{ $surah->_id }})" class="text-white cursor-pointer">Surah Info</p>
            </div>
            <div class="flex justify-end items-center my-5 text-white">
                <span class="mr-1 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" class="size-5">
                        <path
                            d="M6.3 2.84A1.5 1.5 0 0 0 4 4.11v11.78a1.5 1.5 0 0 0 2.3 1.27l9.344-5.891a1.5 1.5 0 0 0 0-2.538L6.3 2.841Z" />
                    </svg>
                </span>
                <p class="cursor-pointer">Play Audio</p>
            </div>
        @endif

        <div class="flex justify-end mr-1 text-white">
            @if (Route::is('surah.show'))
                @livewire('bookmark', ['type' => 'surah', 'item' => $surah])
            @elseif(Route::is('page.show'))
                @livewire('bookmark', ['type' => 'page', 'item' => $page])
            @endif
        </div>



        <div x-data="{ layout: 'byAyah' }" @set-page-layout.window="layout = $event.detail" class="h-auto">
            <template x-if=" layout === 'byAyah' ">
                @livewire('recitation-by-ayah', [ 'surah' => $surah ])
            </template>
            <template x-if=" layout === 'byPage' ">
                @livewire('recitation-by-page', [ 'page' => $surah->ayahs->first()->page])
            </template>
        </div>
    </div>
</x-app-layout>
