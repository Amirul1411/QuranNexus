<div x-data="{ pathParamsOpen: false, queryParamsOpen: false, responseOpen: false }">
    <h1 class="font-bold my-5 text-2xl">Tafseer Info API</h1>
    <div class="my-10">
        <p class="rounded-md px-2 inline-block font-medium">Base URL</p>
        <p>https://quran.seaade2024.com/api/v1</p>
    </div>
    <div class="my-10">
        <p class="text-black inline-block rounded-md px-2 font-medium">Get</p>
        <p>/tafseer_info/:tafseer_id</p>
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
                <p class="rounded-md px-2 inline-block font-medium text-black">tafseer_id <span
                        class="font-normal text-gray-500">string </span><span class="text-red-500">required</span></p>
                <p class="ml-6"> <span class="font-medium text-black">Description: </span>The id of the
                    tafseer info you want to retrieve.
                </p>
                <p class="ml-6"> <span class="font-medium text-black">Possible values: </span>[1 - Ibn Kathir -
                    (Abridged),
                    2 - Ma'arif al-Qur'an]</p>
                <p class="ml-6"> <span class="font-medium text-black">Notes: </span>You may exclude the
                    '/:tafseer_id' from the url if you want to get
                    all tafseer info.</p>
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
                    the tafseer info fields that are required by the user if the user only want to retrieve some of the
                    tafseer info fields. (e.g. Id,Name, ...)
                </p>
                <p class="ml-6"><span class="font-medium text-black">Possible values: </span>[Id, Name, Author
                    Name, Slug, Language Name, Translated Name]</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-black">tafseers</p>
                <p class="ml-6"><span class="font-medium text-black">Description: </span>Load all of the
                    tafseers for that tafseer.</p>
                <p class="ml-6"><span class="font-medium text-black">Possible values: </span>[true, false]</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-black">tafseer_fields</p>
                <p class="ml-6"><span class="font-medium text-black">Description: </span>Comma separated value
                    of the tafseer fields that are required by the user if the user only want to retrieve some of the
                    tafseer fields. (e.g. Id,Html, ...)</p>
                <p class="ml-6"><span class="font-medium text-black">Possible values: </span>[Id, Tafseer Info
                    Id, Surah Id, Ayah Index, Ayah Key, Html]</p>
                <p class="ml-6"><span class="font-medium text-black">Notes: </span>You must set the
                    tafseers query parameters to true in order for this parameter to work.</p>
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
        <div x-show="responseOpen" x-transition class="my-2 ml-6" x-data="{ tafseerInfoOpen: false, tafseerOpen: false, tafseerInfoTranslatedNameOpen: false }">
            <div @click="tafseerInfoOpen = !tafseerInfoOpen"
                class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                <svg :class="{ 'rotate-90': tafseerInfoOpen, 'rotate-0': !tafseerInfoOpen }" x-transition
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                    stroke="currentColor" class="size-4 transition-transform duration-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                <p class="rounded-md px-2 inline-block font-medium">Tafseer Info <span
                        class="font-normal text-gray-500">object</span></p>
            </div>
            <div x-show="tafseerInfoOpen" x-transition class="ml-6">
                <p class="rounded-md px-2 font-medium text-black ml-6">Id <span
                        class="font-normal text-gray-500">string</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Name <span
                        class="font-normal text-gray-500">string</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Author Name <span
                        class="font-normal text-gray-500">string</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Slug <span
                        class="font-normal text-gray-500">string</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Language Name <span
                        class="font-normal text-gray-500">string</span></p>
                <div @click="tafseerInfoTranslatedNameOpen = !tafseerInfoTranslatedNameOpen"
                    class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                    <svg :class="{
                        'rotate-90': tafseerInfoTranslatedNameOpen,
                        'rotate-0': !
                            tafseerInfoTranslatedNameOpen
                    }"
                        x-transition xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="3.5" stroke="currentColor" class="size-4 transition-transform duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                    <p class="rounded-md px-2 inline-block font-medium">Translated Name <span
                            class="font-normal text-gray-500">object</span></p>
                </div>
                <div x-show="tafseerInfoTranslatedNameOpen" x-transition class="ml-6">
                    <p class="rounded-md px-2 font-medium text-black ml-6">Name <span
                            class="font-normal text-gray-500">string</span></p>
                    <p class="rounded-md px-2 font-medium text-black ml-6">Language Name <span
                            class="font-normal text-gray-500">string</span></p>
                </div>
                <div @click="tafseerOpen = !tafseerOpen"
                    class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                    <svg :class="{ 'rotate-90': tafseerOpen, 'rotate-0': !tafseerOpen }" x-transition
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                        stroke="currentColor" class="size-4 transition-transform duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                    <p class="rounded-md px-2 inline-block font-medium">Tafseer <span
                            class="font-normal text-gray-500">object</span></p>
                </div>
                <div x-show="tafseerOpen" x-transition class="ml-6">
                    <p class="rounded-md px-2 font-medium text-black ml-6">Id <span
                            class="font-normal text-gray-500">string</span></p>
                    <p class="rounded-md px-2 font-medium text-black ml-6">Tafseer Info Id <span
                            class="font-normal text-gray-500">string</span></p>
                    <p class="rounded-md px-2 font-medium text-black ml-6">Surah Id <span
                            class="font-normal text-gray-500">string</span></p>
                    <p class="rounded-md px-2 font-medium text-black ml-6">Ayah Index <span
                            class="font-normal text-gray-500">string</span></p>
                    <p class="rounded-md px-2 font-medium text-black ml-6">Ayah Key <span
                            class="font-normal text-gray-500">string</span></p>
                    <p class="rounded-md px-2 font-medium text-black ml-6">Html <span
                            class="font-normal text-gray-500">string</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
