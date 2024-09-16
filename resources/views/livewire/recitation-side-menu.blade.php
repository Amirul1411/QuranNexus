<div class="recitation-side-menu mt-32 h-screen sticky top-0 w-1/3" x-data="{ activeOption: 'surah' }">
    <div class="bg-black rounded-full flex justify-center items-center mx-5 my-5">
        <input type="radio" class="hidden" name="recitationSideMenuOptions" id="surah" autocomplete="off" checked x-model="activeOption" value="surah">
        <label :class="activeOption === 'surah' ? 'bg-gray-600' : 'bg-transparent'" class="hover:bg-gray-500 w-full rounded-full px-5 cursor-pointer py-2 text-white font-serif text-center" for="surah">
            Surah
        </label>

        <input type="radio" class="hidden" name="recitationSideMenuOptions" id="juz" autocomplete="off" x-model="activeOption" value="juz">
        <label :class="activeOption === 'juz' ? 'bg-gray-600' : 'bg-transparent'" class="hover:bg-gray-500 w-full rounded-full px-5 py-2 cursor-pointer text-white font-serif text-center" for="juz">
            Juz
        </label>

        <input type="radio" class="hidden" name="recitationSideMenuOptions" id="page" autocomplete="off" x-model="activeOption" value="page">
        <label :class="activeOption === 'page' ? 'bg-gray-600' : 'bg-transparent'" class="hover:bg-gray-500 w-full rounded-full px-5 py-2 cursor-pointer text-white font-serif text-center" for="page">
            Page
        </label>
    </div>
    <div class="w-full max-w-md">
        <form action="#" class="flex justify-center">
            @csrf
            <div class="relative w-full mx-5 my-5">
                <input type="text" wire:model.live.debounce.250ms="search" class="form-control w-full rounded-full py-2 z-0" placeholder="Search"
                    aria-label="Search" aria-describedby="button-addon2">
            </div>
        </form>
    </div>
    <div class="overflow-y-auto h-3/4">
        <template x-if="activeOption === 'surah'">
            <div>
                @foreach ($this->surahs as $surah)
                    <div wire:click="redirectToSurah({{ $surah->id }})" class="text-white font-sans flex gap-5 mx-5 my-3 hover:cursor-pointer hover:bg-gray-500">
                        <div class="flex justify-center w-5">
                            {{ $surah->id }}
                        </div>
                        <p>{{ $surah->tname }}</p>
                    </div>
                @endforeach
            </div>
        </template>
        <template x-if="activeOption === 'juz'">
            <div>
                @foreach ($this->juzs as $juz)
                    <div wire:click="redirectToJuz({{ $juz->id }})" class="text-white font-sans flex gap-5 mx-5 my-3 hover:cursor-pointer hover:bg-gray-500">
                        <div class="ms-2 flex justify-center w-5">
                            Juz
                        </div>
                        <p>{{ $juz->id }}</p>
                    </div>
                @endforeach
            </div>
        </template>
        <template x-if="activeOption === 'page'">
            <div>
                @foreach ($this->pages as $page)
                    <div wire:click="redirectToPage({{ $page->id }})" class="text-white font-sans flex gap-5 mx-5 my-3 hover:cursor-pointer hover:bg-gray-500">
                        <div class="ms-4 flex justify-center w-5">
                            Page
                        </div>
                        <p>{{ $page->id }}</p>
                    </div>
                @endforeach
            </div>
        </template>
    </div>
</div>
