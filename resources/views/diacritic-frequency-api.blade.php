<div x-data="{ pathParamsOpen: false, queryParamsOpen: false, responseOpen: false }">
    <h1 class="font-bold my-5 text-2xl">Diacritic Frequency API</h1>
    <div class="my-10">
        <p class="rounded-md px-2 inline-block font-medium">Base URL</p>
        <p>https://quran.seaade2024.com/api/v1</p>
    </div>
    <div class="my-10">
        <p class="text-black inline-block rounded-md px-2 font-medium">Get</p>
        <p>/diacritic_frequency/:diacritic_frequency_id</p>
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
                <p class="rounded-md px-2 inline-block font-medium text-black">diacritic_frequency_id <span
                        class="font-normal text-gray-500">string </span><span class="text-red-500">required</span></p>
                <p class="ml-6"> <span class="font-medium text-black">Description: </span>The id of the
                    diacritic frequency you want to retrieve.
                </p>
                <p class="ml-6"> <span class="font-medium text-black">Notes: </span>You may exclude the
                    '/:diacritic_frequency_id' from the url if you want to get
                    all diacritic frequency.</p>
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
                    diacritic frequency fields that are required by the user if the user only want to retrieve some of
                    the diacritic frequency fields. (e.g. Id,Diacritic,Count, ...)
                </p>
                <p class="ml-6"><span class="font-medium text-black">Possible values: </span>[Id, Diacritic,
                    Count, Locations]</p>
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
        <div x-show="responseOpen" x-transition class="my-2 ml-6" x-data="{ diacriticFrequencyOpen: false, diacriticFrequencyLocationsOpen: false }">
            <div @click="diacriticFrequencyOpen = !diacriticFrequencyOpen"
                class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                <svg :class="{ 'rotate-90': diacriticFrequencyOpen, 'rotate-0': !diacriticFrequencyOpen }" x-transition
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                    stroke="currentColor" class="size-4 transition-transform duration-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                <p class="rounded-md px-2 inline-block font-medium">Diacritic Frequency <span
                        class="font-normal text-gray-500">object</span></p>
            </div>
            <div x-show="diacriticFrequencyOpen" x-transition class="ml-6">
                <p class="rounded-md px-2 font-medium text-black ml-6">Id <span
                        class="font-normal text-gray-500">string</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Diacritic <span
                        class="font-normal text-gray-500">string</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Count <span
                        class="font-normal text-gray-500">integer</span></p>
                <div @click="diacriticFrequencyLocationsOpen = !diacriticFrequencyLocationsOpen"
                    class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                    <svg :class="{
                        'rotate-90': diacriticFrequencyLocationsOpen,
                        'rotate-0': !
                        diacriticFrequencyLocationsOpen
                    }"
                        x-transition xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="3.5" stroke="currentColor" class="size-4 transition-transform duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                    <p class="rounded-md px-2 inline-block font-medium">Locations <span
                            class="font-normal text-gray-500">array</span></p>
                </div>
                <div x-show="diacriticFrequencyLocationsOpen" x-transition class="ml-6">
                    <p class="rounded-md px-2 font-medium text-black ml-6">Character Key <span
                            class="font-normal text-gray-500">string</span></p>
                    <p class="rounded-md px-2 font-medium text-black ml-6">Token <span
                            class="font-normal text-gray-500">string</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
