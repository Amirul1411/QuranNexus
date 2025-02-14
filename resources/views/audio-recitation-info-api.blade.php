<div x-data="{ pathParamsOpen: false, queryParamsOpen: false, responseOpen: false }">
    <h1 class="font-bold my-5 text-2xl">Audio Recitation Info API</h1>
    <div class="my-10">
        <p class="rounded-md px-2 inline-block font-medium">Base URL</p>
        <p>http://quran-nexus.ap-southeast-1.elasticbeanstalk.com/api/v1</p>
    </div>
    <div class="my-10">
        <p class="text-black inline-block rounded-md px-2 font-medium">Get</p>
        <p>/audio_recitation_info/:reciter_id</p>
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
                <p class="rounded-md px-2 inline-block font-medium text-black">reciter_id <span
                        class="font-normal text-gray-500">string </span><span class="text-red-500">required</span></p>
                <p class="ml-6"> <span class="font-medium text-black">Description: </span>The id of the audio recitation you want to retrieve.
                </p>
                <p class="ml-6"> <span class="font-medium text-black">Possible values: </span>[1 - Mishari Rashid al-`Afasy,
                    2 - AbdulBaset AbdulSamad]</p>
                <p class="ml-6"> <span class="font-medium text-black">Notes: </span>You may exclude the
                    '/:reciter_id' from the url if you want to get
                    all audio recitation info.</p>
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
                <p class="ml-6"><span class="font-medium text-black">Description: </span>Comma separated value of the audio recitation info fields that are required by the user if the user only want to retrieve some of the audio recitation info fields. (e.g. Id,Reciter Name, ...)

                </p>
                <p class="ml-6"><span class="font-medium text-black">Possible values: </span>[Id, Reciter Name, Style, Translated Name]</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-black">audio_recitations</p>
                <p class="ml-6"><span class="font-medium text-black">Description: </span>Load all of the audio recitations for that reciter's id.</p>
                <p class="ml-6"><span class="font-medium text-black">Possible values: </span>[true, false]</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-black">audio_recitation_fields</p>
                <p class="ml-6"><span class="font-medium text-black">Description: </span>Comma separated value
                    of the audio recitation fields that are required by the user if the user only want to retrieve some
                    of the audio recitation fields. (e.g. Id,Audio Url, ...)</p>
                <p class="ml-6"><span class="font-medium text-black">Possible values: </span>[Id, Audio Info Id,
                    Surah Id]</p>
                <p class="ml-6"><span class="font-medium text-black">Notes: </span>You must set the
                    audio_recitations query parameters to true in order for this parameter to work.</p>
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
        <div x-show="responseOpen" x-transition class="my-2 ml-6" x-data="{ surahOpen: false, surahInfoOpen: false, ayahOpen: false, wordOpen: false, translationInfoOpen: false, translationOpen: false, tafseerInfoOpen: false, tafseerOpen: false, audioRecitationInfoOpen: false, audioRecitationOpen: false, audioRecitationInfoTranslatedNameOpen: false, tafseerInfoTranslatedNameOpen: false, juzOpen: false }">
            <div @click="audioRecitationInfoOpen = !audioRecitationInfoOpen"
                class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                <svg :class="{ 'rotate-90': audioRecitationInfoOpen, 'rotate-0': !audioRecitationInfoOpen }" x-transition
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                    stroke="currentColor" class="size-4 transition-transform duration-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                <p class="rounded-md px-2 inline-block font-medium">Audio Recitation Info <span
                        class="font-normal text-gray-500">object</span></p>
            </div>
            <div x-show="audioRecitationInfoOpen" x-transition class="ml-6">
                <p class="rounded-md px-2 font-medium text-black ml-6">Id <span
                        class="font-normal text-gray-500">string</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Reciter Name <span
                        class="font-normal text-gray-500">string</span></p>
                <p class="rounded-md px-2 font-medium text-black ml-6">Style <span
                        class="font-normal text-gray-500">string</span></p>
                <div @click="audioRecitationInfoTranslatedNameOpen = !audioRecitationInfoTranslatedNameOpen"
                    class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                    <svg :class="{
                        'rotate-90': audioRecitationInfoTranslatedNameOpen,
                        'rotate-0': !
                        audioRecitationInfoTranslatedNameOpen
                    }"
                        x-transition xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="3.5" stroke="currentColor" class="size-4 transition-transform duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                    <p class="rounded-md px-2 inline-block font-medium">Translated Name <span
                            class="font-normal text-gray-500">object</span></p>
                </div>
                <div x-show="audioRecitationInfoTranslatedNameOpen" x-transition class="ml-6">
                    <p class="rounded-md px-2 font-medium text-black ml-6">Name <span
                            class="font-normal text-gray-500">string</span></p>
                    <p class="rounded-md px-2 font-medium text-black ml-6">Language Name <span
                            class="font-normal text-gray-500">string</span></p>
                </div>
                <div @click="audioRecitationOpen = !audioRecitationOpen"
                        class="cursor-pointer rounded-md flex gap-3 items-center text-black ml-6">
                        <svg :class="{ 'rotate-90': audioRecitationOpen, 'rotate-0': !audioRecitationOpen }"
                            x-transition xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="3.5" stroke="currentColor"
                            class="size-4 transition-transform duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                        <p class="rounded-md px-2 inline-block font-medium">Audio Recitation <span
                                class="font-normal text-gray-500">object</span></p>
                    </div>
                    <div x-show="audioRecitationOpen" x-transition class="ml-6">
                        <p class="rounded-md px-2 font-medium text-black ml-6">Id <span
                                class="font-normal text-gray-500">string</span></p>
                        <p class="rounded-md px-2 font-medium text-black ml-6">Audio Info Id <span
                                class="font-normal text-gray-500">string</span></p>
                        <p class="rounded-md px-2 font-medium text-black ml-6">Surah Id <span
                                class="font-normal text-gray-500">string</span></p>
                        <p class="rounded-md px-2 font-medium text-black ml-6">Ayah Index <span
                                class="font-normal text-gray-500">string</span></p>
                        <p class="rounded-md px-2 font-medium text-black ml-6">Ayah Key <span
                                class="font-normal text-gray-500">string</span></p>
                        <p class="rounded-md px-2 font-medium text-black ml-6">Audio Url <span
                                class="font-normal text-gray-500">string</span></p>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
