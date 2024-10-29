<div class="recitation-side-menu mt-32 h-screen sticky top-0 w-1/3"
    x-data="{
        activeOption: 'surah',
        search: '',
        surahs: {{ $this->surahs }},
        juzs: {{ $this->juzs }},
        pages: {{ $this->pages }},
        get filteredSurahs() {
            const searchTerm = this.search.toLowerCase();
            if (searchTerm.length === 0) return this.surahs;

            // Create a dynamic regex pattern to mimic 'LIKE' functionality
            const regex = new RegExp(searchTerm, 'i'); // 'i' flag for case-insensitive matching

            return this.surahs.filter(surah => {
                return surah.tname.toLowerCase().match(regex) ||
                    surah._id.toString().match(regex);
            });
        },
        get filteredJuzs() {
            const searchTerm = this.search.toLowerCase();
            if (searchTerm.length === 0) return this.juzs;

            // Create a dynamic regex pattern to mimic 'LIKE' functionality
            const regex = new RegExp(searchTerm, 'i'); // 'i' flag for case-insensitive matching

            return this.juzs.filter(juz => {
                return juz._id.toString().match(regex);
            });
        },
        get filteredPages() {
            const searchTerm = this.search.toLowerCase();
            if (searchTerm.length === 0) return this.pages;

            // Create a dynamic regex pattern to mimic 'LIKE' functionality
            const regex = new RegExp(searchTerm, 'i'); // 'i' flag for case-insensitive matching

            return this.pages.filter(page => {
                return page._id.toString().match(regex);
            });
        },
    }"
>
    <div class="bg-black rounded-full flex justify-center items-center mx-5 my-5">
        <input type="radio" class="hidden" name="recitationSideMenuOptions" id="surah" autocomplete="off" checked x-model="activeOption" value="surah">
        <label :class="activeOption === 'surah' ? 'bg-gray-600' : 'bg-transparent'" class="hover:bg-gray-500 w-full rounded-full px-5 cursor-pointer py-2 text-white font-serif text-center" for="surah">
            {{ __('recitation.surah') }}
        </label>

        <input type="radio" class="hidden" name="recitationSideMenuOptions" id="juz" autocomplete="off" x-model="activeOption" value="juz">
        <label :class="activeOption === 'juz' ? 'bg-gray-600' : 'bg-transparent'" class="hover:bg-gray-500 w-full rounded-full px-5 py-2 cursor-pointer text-white font-serif text-center" for="juz">
            {{ __('recitation.juz') }}
        </label>

        <input type="radio" class="hidden" name="recitationSideMenuOptions" id="page" autocomplete="off" x-model="activeOption" value="page">
        <label :class="activeOption === 'page' ? 'bg-gray-600' : 'bg-transparent'" class="hover:bg-gray-500 w-full rounded-full px-5 py-2 cursor-pointer text-white font-serif text-center" for="page">
            {{ __('recitation.page') }}
        </label>
    </div>
    <div class="w-full max-w-md">
        <form action="#" class="flex justify-center">
            @csrf
            <div class="relative w-full mx-5 my-5">
                <input type="text" x-model="search" class="form-control w-full rounded-full py-2 z-0" placeholder="Search"
                    aria-label="Search" aria-describedby="button-addon2">
            </div>
        </form>
    </div>
    <div class="overflow-y-auto h-3/4">
        <template x-if="activeOption === 'surah'">
            <div>
                <template x-for="surah in filteredSurahs" :key="surah._id">
                    <div wire:click="redirectToSurah(surah._id)" class="text-white font-sans flex gap-5 mx-5 my-3 px-5 hover:cursor-pointer hover:bg-gray-500">
                        <div class="flex justify-center w-5" x-text="surah._id"></div>
                        <p x-text="surah.tname"></p>
                    </div>
                </template>
            </div>
        </template>
        <template x-if="activeOption === 'juz'">
            <div>
                <template x-for="juz in filteredJuzs" :key="juz._id">
                    <div wire:click="redirectToJuz(juz._id)" class="text-white font-sans flex gap-5 mx-5 my-3 px-5 hover:cursor-pointer hover:bg-gray-500">
                        <div class="ms-2 flex justify-center w-5">
                            {{ __('recitation.juz') }}
                        </div>
                        <p x-text="juz._id"></p>
                    </div>
                </template>
            </div>
        </template>
        <template x-if="activeOption === 'page'">
            <div>
                <template x-for="page in filteredPages" :key="page._id">
                    <div wire:click="redirectToPage(page._id)" class="text-white font-sans flex gap-5 mx-5 my-3 px-5 hover:cursor-pointer hover:bg-gray-500">
                        <div class="ms-4 flex justify-center w-5">
                            {{ __('recitation.page') }}
                        </div>
                        <p x-text="page._id"></p>
                    </div>
                </template>
            </div>
        </template>
    </div>
</div>
