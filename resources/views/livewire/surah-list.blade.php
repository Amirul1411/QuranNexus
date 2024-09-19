<div class="mx-32 w-full">
    <div class="flex justify-center mt-20 py-20">
        <div class="w-full max-w-md">
            <form action="#" class="flex justify-center">
                @csrf
                <div class="relative w-full">
                    <input type="text" wire:model.live.debounce.250ms="search" class="form-control w-full rounded-full pl-12 py-2 z-0"
                        placeholder="What do you want to read?" aria-label="Search" aria-describedby="button-addon2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 z-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <ul class="flex space-x-10 border-b-2 py-4 ps-4">
        <li class="nav-item">
            <a wire:click="$set('selectedNavItem', 'all')"
                class=" {{ $selectedNavItem == 'all' ? 'border-b-2' : '' }} text-white cursor-pointer font-serif"
                aria-current="page">All</a>
        </li>
        @if (Auth::user())
            <li class="nav-item">
                <a wire:click="$set('selectedNavItem', 'recently_read')"
                    class=" {{ $selectedNavItem == 'recently_read' ? 'border-b-2' : '' }} text-white cursor-pointer font-serif">Recently
                    Read</a>
            </li>
            <li class="nav-item">
                <a wire:click="$set('selectedNavItem', 'bookmarks')"
                    class=" {{ $selectedNavItem == 'bookmarks' ? 'border-b-2' : '' }} text-white cursor-pointer font-serif">Bookmarks
                </a>
            </li>
        @endif
    </ul>

    @if ($selectedNavItem == 'all')
        <div class="flex flex-wrap justify-center my-10">
            @foreach ($surahs as $surah)
                <div class="w-1/3 p-5">
                    <div wire:click="redirectToSurah({{ $surah['_id'] }})"
                        class="h-20 flex items-center bg-black text-center p-5 rounded-md cursor-pointer">
                        <div class="w-1/5 relative">
                            <span class="relative flex justify-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-diamond-fill text-gray-600" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.48 1.48 0 0 1 0-2.098z"/>
                                </svg>
                                <p class="absolute text-white text-xl font-bold">{{ $surah['_id'] }}</p>
                            </span>
                        </div>
                        <div class="text-white w-3/5">
                            <h5 class="font-bold text-xl font-serif">{{ $surah['tname'] }}</h5>
                            <p class="text-gray-400 font-bold font-serif text-xs">{{ $surah['ename'] }}</p>
                        </div>
                        <div class="text-white">
                            <h5 class="font-bold text-xl font-serif">{{ $surah['name'] }}</h5>
                            <p class="text-gray-400 font-bold font-serif text-xs">{{ $surah['ayas'] }} Ayahs</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @elseif ($selectedNavItem == 'recently_read')
        <h5 class="text-center text-white">Recently Read</h5>
    @elseif ($selectedNavItem == 'bookmarks')
        <div class="flex flex-col justify-center my-10">
            @if ($this->bookmarkedSurah)
                <div class="text-white text-start font-serif text-lg">
                    Surah
                </div>
                <div class="flex flex-wrap justify-center border-b-2 border-gray">
                    @foreach ($this->bookmarkedSurah as $sura)
                        <div class="w-1/3 p-5">
                            <div wire:click="redirectToSurah({{ $sura['_id'] }})"
                                class="h-20 flex items-center bg-black text-center p-5 rounded-md cursor-pointer">
                                <div class="w-1/5 relative">
                                    <span class="relative flex justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-diamond-fill text-gray-600" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.48 1.48 0 0 1 0-2.098z"/>
                                        </svg>
                                        <p class="absolute text-white text-xl font-bold">{{ $sura['_id'] }}</p>
                                    </span>
                                </div>
                                <div class="text-white w-3/5">
                                    <h5 class="font-bold text-xl font-serif">{{ $sura['tname'] }}</h5>
                                    <p class="text-gray-400 font-bold font-serif text-xs">{{ $sura['ename'] }}</p>
                                </div>
                                <div class="text-white">
                                    <h5 class="font-bold text-xl font-serif">{{ $sura['name'] }}</h5>
                                    <p class="text-gray-400 font-bold font-serif text-xs">{{ $sura['ayas'] }} Ayahs</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if ($this->bookmarkedAyah)
                <div class="text-white text-start font-serif text-lg">
                    Ayah
                </div>
                <div class="flex flex-wrap justify-center border-b-2 border-gray">
                    @foreach ($this->bookmarkedAyah as $aya)
                        <div class="w-1/3 p-5">
                            <div wire:click=""
                                class="h-20 flex items-center bg-black text-center p-5 rounded-md cursor-pointer">
                                <div class="w-1/5 relative">
                                    <span class="relative flex justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-diamond-fill text-gray-600" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.48 1.48 0 0 1 0-2.098z"/>
                                        </svg>
                                        <p class="absolute text-white text-xl font-bold">{{ $aya->surah['_id'] }}</p>
                                    </span>
                                </div>
                                <div class="text-white w-3/5">
                                    <h5 class="font-bold text-xl font-serif">{{ $aya->surah['tname'] }}</h5>
                                    <p class="text-gray-400 font-bold font-serif text-xs">{{ $aya->surah['ename'] }}</p>
                                </div>
                                <div class="text-white">
                                    <h5 class="font-bold text-xl font-serif">{{ $aya->surah['name'] }}</h5>
                                    <p class="text-gray-400 font-bold font-serif text-xs"> Ayah {{ $aya->ayah_index }} </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if ($this->bookmarkedPage)
                <div class="text-white text-start font-serif text-lg">
                    Page
                </div>
                <div class="flex flex-wrap justify-center border-b-2 border-gray">
                    @foreach ($this->bookmarkedPage as $page)
                        <div class="w-1/3 p-5">
                            <div wire:click="redirectToPage({{ $page->id }})"
                                class="h-20 flex items-center bg-black text-center p-5 rounded-md cursor-pointer">
                                <div class="w-1/5 relative">
                                    <span class="relative flex justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-diamond-fill text-gray-600" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.48 1.48 0 0 1 0-2.098z"/>
                                        </svg>
                                        <p class="absolute text-white text-xl font-bold">{{ $page->ayahs->first()->surah['_id'] }}</p>
                                    </span>
                                </div>
                                <div class="text-white w-3/5">
                                    <h5 class="font-bold text-xl font-serif">{{ $aya->surah['tname'] }}</h5>
                                    <p class="text-gray-400 font-bold font-serif text-xs">{{ $page->ayahs->first()->surah['ename'] }}</p>
                                </div>
                                <div class="text-white">
                                    <h5 class="font-bold text-xl font-serif">{{ $page->ayahs->first()->surah['name'] }}</h5>
                                    <p class="text-gray-400 font-bold font-serif text-xs"> Page {{ $page->id }} </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

</div>
