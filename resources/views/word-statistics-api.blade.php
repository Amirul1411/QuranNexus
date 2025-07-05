<div x-data="{ pathParamsOpen: false, queryParamsOpen: false, responseOpen: false }">
    <h1 class="font-bold my-5 text-2xl">Word Statistics API</h1>
    <div class="my-10">
        <p class="rounded-md px-2 inline-block font-medium">Base URL</p>
        <p>https://quran.seaade2024.com/api/v1</p>
    </div>
    <div class="my-10">
        <p class="text-black inline-block rounded-md px-2 font-medium">Get</p>
        <p>/word_statistics/:word_statistics_id</p>
    </div>
    <div class="my-10">
        <div @click="pathParamsOpen = !pathParamsOpen" class="cursor-pointer p-2 rounded-md flex gap-3 items-center">
            <svg :class="{ 'rotate-90': pathParamsOpen, 'rotate-0': !pathParamsOpen }" x-transition
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4 transition-transform duration-300">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
            <p class="font-bold">Path Parameters</p>
        </div>
        <div x-show="pathParamsOpen" x-transition class="my-2 ml-6">
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-black">word_statistics_id <span
                        class="font-normal text-gray-500">string </span><span class="text-red-500">required</span></p>
                <p class="ml-6"> <span class="font-medium text-black">Description: </span>The id of the
                    word statistics you want to retrieve.
                </p>
                <p class="ml-6"> <span class="font-medium text-black">Notes: </span>You may exclude the
                    '/:word_statistics_id' from the url if you want to get
                    all word statistics.</p>
            </div>
        </div>
    </div>
    <div class="my-10">
        <div @click="queryParamsOpen = !queryParamsOpen" class="cursor-pointer p-2 rounded-md flex gap-3 items-center">
            <svg :class="{ 'rotate-90': queryParamsOpen, 'rotate-0': !queryParamsOpen }" x-transition
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4 transition-transform duration-300">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
            <p class="font-bold">Query Parameters</p>
        </div>
        <div x-show="queryParamsOpen" x-transition class="my-2 ml-6">
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-black">fields</p>
                <p class="ml-6"><span class="font-medium text-black">Description: </span>Comma separated value of the
                    word statistics fields that are required by the user if the user only want to retrieve some of the
                    word statistics fields. (e.g. Id,Word,Translation, ...)
                </p>
                <p class="ml-6"><span class="font-medium text-black">Possible values: </span>[Id, Word,
                    Transliteration, Translation, Characters, Total Occurrences, Occurrences by Surah, Occurrences by
                    Juz, Occurrences by Page, Positions]</p>
            </div>
        </div>
    </div>
    <div class="my-10">
        <div @click="responseOpen = !responseOpen" class="cursor-pointer p-2 rounded-md flex gap-3 items-center">
            <svg :class="{ 'rotate-90': responseOpen, 'rotate-0': !responseOpen }" x-transition
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4 transition-transform duration-300">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
            <p class="font-bold">Response</p>
        </div>
        <div x-show="responseOpen" x-transition class="my-2 ml-6" x-data="{ wordStatisticsOpen: false, wordStatisticsOccurrencesBySurahOpen: false, wordStatisticsOccurrencesByJuzOpen: false, wordStatisticsOccurrencesByPageOpen: false, wordStatisticsPositionsOpen: false, wordStatisticsPositionsPagePositionsOpen: false, wordStatisticsPositionsPagePositionsLinesOpen: false }">
            <div @click="wordStatisticsOpen = !wordStatisticsOpen"
                class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                <svg :class="{ 'rotate-90': wordStatisticsOpen, 'rotate-0': !wordStatisticsOpen }" x-transition
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                    stroke="currentColor" class="size-4 transition-transform duration-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                <p class="rounded-md px-2 inline-block font-medium">Word Statistics <span
                        class="font-normal text-gray-500">object</span></p>
            </div>
            <div x-show="wordStatisticsOpen" x-transition class="ml-6">
                <p class="rounded-md px-2 font-medium text-black ml-6">Id <span
                        class="font-normal text-gray-500">string</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Word <span
                        class="font-normal text-gray-500">string</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Transliteration <span
                        class="font-normal text-gray-500">string</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Translation <span
                        class="font-normal text-gray-500">string</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Characters <span
                        class="font-normal text-gray-500">array</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Total Occurrences <span
                        class="font-normal text-gray-500">integer</span></p>
                <div @click="wordStatisticsOccurrencesBySurahOpen = !wordStatisticsOccurrencesBySurahOpen"
                    class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                    <svg :class="{
                        'rotate-90': wordStatisticsOccurrencesBySurahOpen,
                        'rotate-0': !
                            wordStatisticsOccurrencesBySurahOpen
                    }"
                        x-transition xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="3.5" stroke="currentColor" class="size-4 transition-transform duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                    <p class="rounded-md px-2 inline-block font-medium">Occurrences by Surah <span
                            class="font-normal text-gray-500">array</span></p>
                </div>
                <div x-show="wordStatisticsOccurrencesBySurahOpen" x-transition class="ml-6">
                    <p class="rounded-md px-2 font-medium text-black ml-6">Surah Id <span
                            class="font-normal text-gray-500">integer</span></p>
                    <p class="rounded-md px-2 font-medium text-black ml-6">Count <span
                            class="font-normal text-gray-500">integer</span></p>
                </div>
                <div @click="wordStatisticsOccurrencesByJuzOpen = !wordStatisticsOccurrencesByJuzOpen"
                    class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                    <svg :class="{
                        'rotate-90': wordStatisticsOccurrencesByJuzOpen,
                        'rotate-0': !
                            wordStatisticsOccurrencesByJuzOpen
                    }"
                        x-transition xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="3.5" stroke="currentColor" class="size-4 transition-transform duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                    <p class="rounded-md px-2 inline-block font-medium">Occurrences by Juz <span
                            class="font-normal text-gray-500">array</span></p>
                </div>
                <div x-show="wordStatisticsOccurrencesByJuzOpen" x-transition class="ml-6">
                    <p class="rounded-md px-2 font-medium text-black ml-6">Juz Id <span
                            class="font-normal text-gray-500">integer</span></p>
                    <p class="rounded-md px-2 font-medium text-black ml-6">Count <span
                            class="font-normal text-gray-500">integer</span></p>
                </div>
                <div @click="wordStatisticsOccurrencesByPageOpen = !wordStatisticsOccurrencesByPageOpen"
                    class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                    <svg :class="{
                        'rotate-90': wordStatisticsOccurrencesByPageOpen,
                        'rotate-0': !
                            wordStatisticsOccurrencesByPageOpen
                    }"
                        x-transition xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="3.5" stroke="currentColor" class="size-4 transition-transform duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                    <p class="rounded-md px-2 inline-block font-medium">Occurrences by Page <span
                            class="font-normal text-gray-500">array</span></p>
                </div>
                <div x-show="wordStatisticsOccurrencesByPageOpen" x-transition class="ml-6">
                    <p class="rounded-md px-2 font-medium text-black ml-6">Page Id <span
                            class="font-normal text-gray-500">integer</span></p>
                    <p class="rounded-md px-2 font-medium text-black ml-6">Count <span
                            class="font-normal text-gray-500">integer</span></p>
                </div>
                <div @click="wordStatisticsPositionsOpen = !wordStatisticsPositionsOpen"
                    class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                    <svg :class="{
                        'rotate-90': wordStatisticsPositionsOpen,
                        'rotate-0': !
                            wordStatisticsPositionsOpen
                    }"
                        x-transition xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="3.5" stroke="currentColor" class="size-4 transition-transform duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                    <p class="rounded-md px-2 inline-block font-medium">Positions <span
                            class="font-normal text-gray-500">object</span></p>
                </div>
                <div x-show="wordStatisticsPositionsOpen" x-transition class="ml-6">
                    <p class="ml-6 rounded-md px-2 inline-block font-medium">Word Keys <span
                            class="font-normal text-gray-500">array</span></p>
                    <div @click="wordStatisticsPositionsPagePositionsOpen = !wordStatisticsPositionsPagePositionsOpen"
                        class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                        <svg :class="{
                            'rotate-90': wordStatisticsPositionsPagePositionsOpen,
                            'rotate-0': !
                                wordStatisticsPositionsPagePositionsOpen
                        }"
                            x-transition xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="3.5" stroke="currentColor"
                            class="size-4 transition-transform duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                        <p class="rounded-md px-2 inline-block font-medium">Page Positions <span
                                class="font-normal text-gray-500">array</span></p>
                    </div>
                    <div x-show="wordStatisticsPositionsPagePositionsOpen" x-transition class="ml-6">
                        <p class="rounded-md px-2 font-medium text-black ml-6">Page Id <span
                                class="font-normal text-gray-500">integer</span></p>
                        <p class="rounded-md px-2 font-medium text-black ml-6">Total Count <span
                                class="font-normal text-gray-500">integer</span></p>
                        <div @click="wordStatisticsPositionsPagePositionsLinesOpen = !wordStatisticsPositionsPagePositionsLinesOpen"
                            class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                            <svg :class="{
                                'rotate-90': wordStatisticsPositionsPagePositionsLinesOpen,
                                'rotate-0': !
                                wordStatisticsPositionsPagePositionsLinesOpen
                            }"
                                x-transition xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="3.5" stroke="currentColor"
                                class="size-4 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                            <p class="rounded-md px-2 inline-block font-medium">Lines <span
                                    class="font-normal text-gray-500">array</span></p>
                        </div>
                        <div x-show="wordStatisticsPositionsPagePositionsLinesOpen" x-transition class="ml-6">
                            <p class="rounded-md px-2 font-medium text-black ml-6">Line Number <span
                                    class="font-normal text-gray-500">integer</span></p>
                            <p class="rounded-md px-2 font-medium text-black ml-6">Count <span
                                    class="font-normal text-gray-500">integer</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
