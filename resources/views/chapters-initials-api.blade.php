<div x-data="{ pathParamsOpen: false, queryParamsOpen: false, responseOpen: false }">
    <h1 class="font-bold my-5 text-2xl">Chapters Initials API</h1>
    <div class="my-10">
        <p class="rounded-md px-2 inline-block font-medium">Base URL</p>
        <p>https://quran.seaade2024.com/api/v1</p>
    </div>
    <div class="my-10">
        <p class="text-black inline-block rounded-md px-2 font-medium">Get</p>
        <p>/chapters_initials/:chapters_initials_id</p>
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
                <p class="rounded-md px-2 inline-block font-medium text-black">chapters_initials_id <span
                        class="font-normal text-gray-500">string </span><span class="text-red-500">required</span></p>
                <p class="ml-6"> <span class="font-medium text-black">Description: </span>The id of the
                    chapters initials you want to retrieve.
                </p>
                <p class="ml-6"> <span class="font-medium text-black">Notes: </span>You may exclude the
                    '/:chapters_initials_id' from the url if you want to get
                    all chapters initials.</p>
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
                    chapters initials fields that are required by the user if the user only want to retrieve some of the
                    chapters initials fields. (e.g. Id,Surah Id,Ayah Key, ...)
                </p>
                <p class="ml-6"><span class="font-medium text-black">Possible values: </span>[Id, Surah Id,
                    Ayah Key, Initials]</p>
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
        <div x-show="responseOpen" x-transition class="my-2 ml-6" x-data="{ chaptersInitialsOpen: false }">
            <div @click="chaptersInitialsOpen = !chaptersInitialsOpen"
                class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                <svg :class="{ 'rotate-90': chaptersInitialsOpen, 'rotate-0': !chaptersInitialsOpen }" x-transition
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                    stroke="currentColor" class="size-4 transition-transform duration-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                <p class="rounded-md px-2 inline-block font-medium">Chapters Initials <span
                        class="font-normal text-gray-500">object</span></p>
            </div>
            <div x-show="chaptersInitialsOpen" x-transition class="ml-6">
                <p class="rounded-md px-2 font-medium text-black ml-6">Id <span
                        class="font-normal text-gray-500">string</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Surah Id <span
                        class="font-normal text-gray-500">string</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Ayah Key <span
                        class="font-normal text-gray-500">string</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Initials <span
                        class="font-normal text-gray-500">string</span></p>
            </div>
        </div>
    </div>
</div>
