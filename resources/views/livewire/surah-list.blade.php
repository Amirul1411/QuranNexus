<div class="mx-32 w-full" x-data="{
    search: '',
    surahs: {{ $surahs }},
    recentlyReadSurah: {{ $this->recentlyReadSurah }},
    recentlyReadJuz: {{ $this->recentlyReadJuz }},
    recentlyReadPage: {{ $this->recentlyReadPage }},
    bookmarkedSurah: {{ $this->bookmarkedSurah }},
    bookmarkedAyah: {{ $this->bookmarkedAyah }},
    bookmarkedPage: {{ $this->bookmarkedPage }},
    get filteredSurahs() {
        const searchTerm = this.search.toLowerCase();
        if (searchTerm.length === 0) return this.surahs;

        // Create a dynamic regex pattern to mimic 'LIKE' functionality
        const regex = new RegExp(searchTerm, 'i'); // 'i' flag for case-insensitive matching

        return this.surahs.filter(surah => {
            return surah.tname.toLowerCase().match(regex) ||
                surah.ename.toLowerCase().match(regex) ||
                surah._id.toString().match(regex);
        });
    },
    get filteredRecentlyReadSurahs() {
        const searchTerm = this.search.toLowerCase();
        if (searchTerm.length === 0) return this.recentlyReadSurah;

        // Create a dynamic regex pattern to mimic 'LIKE' functionality
        const regex = new RegExp(searchTerm, 'i'); // 'i' flag for case-insensitive matching

        return this.recentlyReadSurah.filter(surah => {
            return surah.tname.toLowerCase().match(regex) ||
                surah.ename.toLowerCase().match(regex) ||
                surah._id.toString().match(regex);
        });
    },
    get filteredRecentlyReadJuzs() {
        const searchTerm = this.search.toLowerCase();
        if (searchTerm.length === 0) return this.recentlyReadJuz;

        // Create a dynamic regex pattern to mimic 'LIKE' functionality
        const regex = new RegExp(searchTerm, 'i'); // 'i' flag for case-insensitive matching

        return this.recentlyReadJuz.filter(juz => {
            return juz._id.toString().match(regex);
        });
    },
    get filteredRecentlyReadPages() {
        const searchTerm = this.search.toLowerCase();
        if (searchTerm.length === 0) return this.recentlyReadPage;

        // Create a dynamic regex pattern to mimic 'LIKE' functionality
        const regex = new RegExp(searchTerm, 'i'); // 'i' flag for case-insensitive matching

        return this.recentlyReadPage.filter(page => {
            return page._id.toString().match(regex);
        });
    },
    get filteredBookmarkedSurahs() {
        const searchTerm = this.search.toLowerCase();
        if (searchTerm.length === 0) return this.bookmarkedSurah;

        // Create a dynamic regex pattern to mimic 'LIKE' functionality
        const regex = new RegExp(searchTerm, 'i'); // 'i' flag for case-insensitive matching

        return this.bookmarkedSurah.filter(surah => {
            return surah.tname.toLowerCase().match(regex) ||
                surah.ename.toLowerCase().match(regex) ||
                surah._id.toString().match(regex);
        });
    },
    get filteredBookmarkedAyahs() {
        const searchTerm = this.search.toLowerCase();
        if (searchTerm.length === 0) return this.bookmarkedAyah;

        // Create a dynamic regex pattern to mimic 'LIKE' functionality
        const regex = new RegExp(searchTerm, 'i'); // 'i' flag for case-insensitive matching

        return this.bookmarkedAyah.filter(ayah => {
            return ayah.surah.tname.toLowerCase().match(regex) ||
                ayah.surah.ename.toLowerCase().match(regex) ||
                ayah.surah._id.toString().match(regex) ||
                ayah.ayah_index.toString().match(regex);
        });
    },
    get filteredBookmarkedPages() {
        const searchTerm = this.search.toLowerCase();
        if (searchTerm.length === 0) return this.bookmarkedPage;

        // Create a dynamic regex pattern to mimic 'LIKE' functionality
        const regex = new RegExp(searchTerm, 'i'); // 'i' flag for case-insensitive matching

        return this.bookmarkedPage.filter(page => {
            return page._id.toString().match(regex);
        });
    },
}">
    <div class="flex justify-center mt-20 py-20">
        <div class="w-full max-w-md">
            <form action="#" class="flex justify-center">
                @csrf
                <div class="relative w-full">
                    <input x-model="search" class="form-control w-full rounded-full pl-12 py-2 z-0"
                        placeholder="What do you want to read?">
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
                aria-current="page">{{ __('surah_list.all') }}</a>
        </li>
        @if (Auth::user())
            <li class="nav-item">
                <a wire:click="$set('selectedNavItem', 'recently_read')"
                    class=" {{ $selectedNavItem == 'recently_read' ? 'border-b-2' : '' }} text-white cursor-pointer font-serif">{{ __('surah_list.recently_read') }}</a>
            </li>
            <li class="nav-item">
                <a wire:click="$set('selectedNavItem', 'bookmarks')"
                    class=" {{ $selectedNavItem == 'bookmarks' ? 'border-b-2' : '' }} text-white cursor-pointer font-serif">{{ __('surah_list.bookmarks') }}
                </a>
            </li>
        @endif
    </ul>

    @if ($selectedNavItem == 'all')
        <div class="flex flex-wrap justify-center my-3">
            <template x-for="surah in filteredSurahs" :key="surah._id">
                <div class="w-1/3 p-5">
                    <div wire:click="redirectToSurah(surah._id)"
                        class="h-20 flex items-center bg-black text-center p-5 rounded-md cursor-pointer">
                        <div class="w-1/5 relative">
                            <span class="relative flex justify-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                    fill="currentColor" class="bi bi-diamond-fill text-gray-600" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.48 1.48 0 0 1 0-2.098z" />
                                </svg>
                                <p class="absolute text-white text-xl font-bold" x-text="surah._id"></p>
                            </span>
                        </div>
                        <div class="text-white w-3/5">
                            <h5 class="font-bold text-xl font-serif" x-text="surah.tname"></h5>
                            <p class="text-gray-400 font-bold font-serif text-xs" x-text="surah.ename"></p>
                        </div>
                        <div class="text-white">
                            <h5 class="font-bold text-xl font-serif" x-text="surah.name"></h5>
                            <p class="text-gray-400 font-bold font-serif text-xs" x-text="surah.ayas + ' Ayahs'"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    @elseif ($selectedNavItem == 'recently_read')
        <div class="flex flex-col justify-center my-3">
            @if ($this->recentlyReadSurah && count($this->recentlyReadSurah) > 0)
                <div class="text-white text-start font-serif text-lg my-3">
                    {{ __('surah_list.surah') }}
                </div>
                <div class="flex flex-wrap justify-center">
                    <template x-for="surah in filteredRecentlyReadSurahs" :key="surah._id">
                        <div class="w-1/3 p-5">
                            <div wire:click="redirectToSurah(surah._id)"
                                class="h-20 flex items-center bg-black text-center p-5 rounded-md cursor-pointer">
                                <div class="w-1/5 relative">
                                    <span class="relative flex justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                            fill="currentColor" class="bi bi-diamond-fill text-gray-600"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.48 1.48 0 0 1 0-2.098z" />
                                        </svg>
                                        <p class="absolute text-white text-xl font-bold" x-text="surah._id"></p>
                                    </span>
                                </div>
                                <div class="text-white w-3/5">
                                    <h5 class="font-bold text-xl font-serif" x-text="surah.tname"></h5>
                                    <p class="text-gray-400 font-bold font-serif text-xs" x-text="surah.ename"></p>
                                </div>
                                <div class="text-white">
                                    <h5 class="font-bold text-xl font-serif" x-text="surah.name"></h5>
                                    <p class="text-gray-400 font-bold font-serif text-xs" x-text="surah.ayas + ' Ayahs'"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            @endif
            <x-section-border />
            @if ($this->recentlyReadJuz && count($this->recentlyReadJuz) > 0)
                <div class="text-white text-start font-serif text-lg my-3">
                    {{ __('surah_list.juz') }}
                </div>
                <div class="flex flex-wrap justify-center">
                    <template x-for="juz in filteredRecentlyReadJuzs" :key="juz._id">
                        <div class="w-1/3 p-5">
                            <div wire:click="redirectToJuz(juz._id)"
                                class="h-20 flex items-center bg-black text-center p-5 rounded-md cursor-pointer">
                                <div class="text-white w-full">
                                    <h5 class="font-bold text-xl font-serif" x-text="'Juz ' + juz._id"></h5>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            @endif
            <x-section-border />
            @if ($this->recentlyReadPage && count($this->recentlyReadPage) > 0)
                <div class="text-white text-start font-serif text-lg">
                    {{ __('surah_list.page') }}
                </div>
                <div class="flex flex-wrap justify-center">
                    <template x-for="page in filteredRecentlyReadPages" :key="page._id">
                        <div class="w-1/3 p-5">
                            <div wire:click="redirectToPage(page._id)"
                                class="h-20 flex items-center bg-black text-center p-5 rounded-md cursor-pointer">
                                <div class="text-white w-full">
                                    <h5 class="font-bold text-xl font-serif" x-text="'Page ' + page._id"></h5>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            @endif
        </div>
    @elseif ($selectedNavItem == 'bookmarks')
        <div class="flex flex-col justify-center my-3">
            @if ($this->bookmarkedSurah && count($this->bookmarkedSurah) > 0)
                <div class="text-white text-start font-serif text-lg">
                    {{ __('surah_list.surah') }}
                </div>
                <div class="flex flex-wrap justify-center">
                    <template x-for="surah in filteredBookmarkedSurahs" :key="surah._id">
                        <div class="w-1/3 p-5">
                            <div wire:click="redirectToSurah(surah._id)"
                                class="h-20 flex items-center bg-black text-center p-5 rounded-md cursor-pointer">
                                <div class="w-1/5 relative">
                                    <span class="relative flex justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                            fill="currentColor" class="bi bi-diamond-fill text-gray-600"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.48 1.48 0 0 1 0-2.098z" />
                                        </svg>
                                        <p class="absolute text-white text-xl font-bold" x-text="surah._id"></p>
                                    </span>
                                </div>
                                <div class="text-white w-3/5">
                                    <h5 class="font-bold text-xl font-serif" x-text="surah.tname"></h5>
                                    <p class="text-gray-400 font-bold font-serif text-xs" x-text="surah.ename"></p>
                                </div>
                                <div class="text-white">
                                    <h5 class="font-bold text-xl font-serif" x-text="surah.name"></h5>
                                    <p class="text-gray-400 font-bold font-serif text-xs" x-text="surah.ayas + ' Ayahs'">
                                    </p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            @endif
            @if ($this->bookmarkedAyah && count($this->bookmarkedAyah) > 0)
                <div class="text-white text-start font-serif text-lg my-3 border-t-2 border-gray-500 pt-3">
                    {{ __('surah_list.ayah') }}
                </div>
                <div class="flex flex-wrap justify-center">
                    <template x-for="ayah in filteredBookmarkedAyahs" :key="ayah._id">
                        <div class="w-1/3 p-5">
                            <div wire:click="redirectToAyah(ayah.ayah_key)"
                                class="h-20 flex items-center bg-black text-center p-5 rounded-md cursor-pointer">
                                <div class="w-1/5 relative">
                                    <span class="relative flex justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                            fill="currentColor" class="bi bi-diamond-fill text-gray-600"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.48 1.48 0 0 1 0-2.098z" />
                                        </svg>
                                        <p class="absolute text-white text-xl font-bold" x-text="ayah.surah._id"></p>
                                    </span>
                                </div>
                                <div class="text-white w-3/5">
                                    <h5 class="font-bold text-xl font-serif" x-text="ayah.surah.tname"></h5>
                                    <p class="text-gray-400 font-bold font-serif text-xs" x-text="ayah.surah.ename">
                                    </p>
                                </div>
                                <div class="text-white">
                                    <h5 class="font-bold text-xl font-serif" x-text="ayah.surah.name"></h5>
                                    <p class="text-gray-400 font-bold font-serif text-xs" x-text="'Ayah ' + ayah.ayah_index">
                                    </p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            @endif
            @if ($this->bookmarkedPage && count($this->bookmarkedPage) > 0)
                <div class="text-white text-start font-serif text-lg my-3 border-t-2 border-gray-500 pt-3">
                    {{ __('surah_list.page') }}
                </div>
                <div class="flex flex-wrap justify-center">
                    <template x-for="page in filteredBookmarkedPages" :key="page._id">
                        <div class="w-1/3 p-5">
                            <div wire:click="redirectToPage(page._id)"
                                class="h-20 flex items-center bg-black text-center p-5 rounded-md cursor-pointer">
                                <div class="text-white w-full">
                                    <h5 class="font-bold text-xl font-serif" x-text="'Page ' + page._id"></h5>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            @endif
        </div>
    @endif

</div>
