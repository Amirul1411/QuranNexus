<div x-data="{ pathParamsOpen: false, queryParamsOpen: false, responseOpen: false }">
    <h1 class="font-bold my-5 text-2xl">Surah Info API</h1>
    <div class="my-10">
        <p class="rounded-md px-2 inline-block font-medium">Base URL</p>
        <p>http://quran-nexus.ap-southeast-1.elasticbeanstalk.com/api/v1</p>
    </div>
    <div class="my-10">
        <p class="text-black inline-block rounded-md px-2 font-medium">Get</p>
        <p>/surah_info/:surah_id</p>
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
                <p class="rounded-md px-2 inline-block font-medium text-black">surah_id <span
                        class="font-normal text-gray-500">string </span><span class="text-red-500">required</span></p>
                <p class="ml-6"> <span class="font-medium text-black">Description: </span>The ID of the surah</p>
                <p class="ml-6"> <span class="font-medium text-black">Possible values: </span>1-114</p>
                <p class="ml-6"> <span class="font-medium text-black">Notes: </span>You may exclude the
                    '/:surah_id' from the url if you want to get
                    all surahs.</p>
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
                <p class="ml-6"><span class="font-medium text-black">Description: </span>Comma separated value of
                    the surah info fields that are required by the user if the user only want to retrieve some of the
                    surah info fields. (e.g. Id,Html)</p>
                <p class="ml-6"><span class="font-medium text-black">Possible values: </span>[Id
                    Html]</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-black">surah</p>
                <p class="ml-6"><span class="font-medium text-black">Description: </span>Load the surah for the
                    surah info.</p>
                <p class="ml-6"><span class="font-medium text-black">Possible values: </span>[true, false]</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-black">surah_fields</p>
                <p class="ml-6"><span class="font-medium text-black">Description: </span>Comma separated value of
                    the surah fields that are required by the user if the user only want to retrieve some of the surah
                    fields. (e.g. Id,Name,Arabic Name, ...)</p>
                <p class="ml-6"><span class="font-medium text-black">Possible values: </span>[Id, Arabic Name,
                    Name, Name Meaning, Type, Number of Ayahs]</p>
                <p class="ml-6"><span class="font-medium text-black">Notes: </span>you must set the surah query
                    parameter to true in order for this parameter to work.</p>
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
        <div x-show="responseOpen" x-transition class="my-2 ml-6" x-data="{ surahOpen: false, surahInfoOpen: false }">
            <div @click="surahInfoOpen = !surahInfoOpen"
                class="cursor-pointer px-2 rounded-md flex gap-3 items-center text-black">
                <svg :class="{ 'rotate-90': surahInfoOpen, 'rotate-0': !surahInfoOpen }" x-transition
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                    stroke="currentColor" class="size-4 transition-transform duration-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                <p class="rounded-md px-2 inline-block font-medium">Surah Info <span
                        class="font-normal text-gray-500">object</span></p>
            </div>
            <div x-show="surahInfoOpen" x-transition class="ml-6">
                <p class="rounded-md px-2 font-medium text-black ml-6">Id <span
                        class="font-normal text-gray-500">string</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Html <span
                        class="font-normal text-gray-500">string</span></p>
                <div @click="surahOpen = !surahOpen"
                    class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                    <svg :class="{ 'rotate-90': surahOpen, 'rotate-0': !surahOpen }" x-transition
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                        stroke="currentColor" class="size-4 transition-transform duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                    <p class="rounded-md px-2 inline-block font-medium">Surah <span
                            class="font-normal text-gray-500">object</span></p>
                </div>
                <div x-show="surahOpen" x-transition class="ml-6">
                    <p class="rounded-md px-2 font-medium text-black ml-6">Id <span
                            class="font-normal text-gray-500">string</span></p>
                    <p class="rounded-md px-2 font-medium text-black ml-6">Arabic Name <span
                            class="font-normal text-gray-500">string</span></p>
                    <p class="rounded-md px-2 font-medium text-black ml-6">Name <span
                            class="font-normal text-gray-500">string</span></p>
                    <p class="rounded-md px-2 font-medium text-black ml-6">Name Meaning <span
                            class="font-normal text-gray-500">string</span></p>
                    <p class="rounded-md px-2 font-medium text-black ml-6">Type <span
                            class="font-normal text-gray-500">string</span></p>
                    <p class="rounded-md px-2 font-medium text-black ml-6">Number of Ayahs <span
                            class="font-normal text-gray-500">integer</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
