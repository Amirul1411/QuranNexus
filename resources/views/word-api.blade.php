<div x-data="{ pathParamsOpen: false, queryParamsOpen: false, responseOpen: false }">
    <h1 class="font-bold my-5 text-2xl">Word API</h1>
    <div class="my-10">
        <p class="border-2 rounded-md px-2 inline-block font-medium">Base URL</p>
        <p>http://quran-nexus.ap-southeast-1.elasticbeanstalk.com/api/v1</p>
    </div>
    <div class="my-10">
        <p class="bg-[#79FFDF] text-black inline-block rounded-md px-2 font-medium">Get</p>
        <p>/words/:word_key</p>
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
                <p class="rounded-md px-2 inline-block font-medium text-green-400">word_key <span
                        class="font-normal text-gray-400">string </span><span class="text-red-500">required</span></p>
                <p class="ml-6"> <span class="font-medium text-green-400">Description: </span>The word you want to
                    find. It is a combination of surah_id, ayah_index, and word_index. (e.g. 1:1:1)</p>
                <p class="ml-6"> <span class="font-medium text-green-400">Notes: </span>Make sure the surah_id
                    ayah_index, and word_index are separated by ':'. Also, you may exclude the
                    '/:word_key' from the url if you want to get
                    all words.</p>
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
                <p class="rounded-md px-2 inline-block font-medium text-green-400">fields</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Comma separated value of
                    the word fields that are required by the user if the user only want to retrieve some of the word
                    fields. (e.g. Id,Surah Id,Ayah Index, ...)</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[Id, Surah Id, Ayah
                    Index, Word Index, Ayah Key, Word Key, Audio Url, Page Id, Line Number, Text, Characters,
                    Translation, Transliteration]</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">surah</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Load the surah for the
                    word.</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[true, false]</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">surah_fields</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Comma separated value of
                    the surah fields that are required by the user if the user only want to retrieve some of the surah
                    fields. (e.g. Id,Name,Arabic Name, ...)</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[Id, Arabic Name,
                    Name, Name Meaning, Type, Number of Ayahs]</p>
                <p class="ml-6"><span class="font-medium text-green-400">Notes: </span>You must set the surah query
                    parameter to true in order for this parameter to work.</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">surah_info</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Load the surah info for
                    that surah.</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[true, false]</p>
                <p class="ml-6"><span class="font-medium text-green-400">Notes: </span>You must set the surah query
                    parameter to true in order for this parameter to work.</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">surah_info_fields</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Comma separated value of
                    the surah info fields that are required by the user if the user only want to retrieve some of the
                    surah info fields. (e.g. Id,Html)</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[Id, Html]</p>
                <p class="ml-6"><span class="font-medium text-green-400">Notes: </span>You must set the surah and
                    surah_info
                    query parameters to true in order for this parameter to work.</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">ayah</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Load the ayah for the
                    word.</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[true, false]</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">ayah_fields</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Comma separated value of
                    the ayah fields that are required by the user if the user only want to retrieve some of the ayah
                    fields. (e.g. Id,Surah Id,Ayah Index, ...)</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[Id, Surah Id, Ayah
                    Index, Ayah
                    Key, Page Id, Juz Id, Bismillah]</p>
                <p class="ml-6"><span class="font-medium text-green-400">Notes: </span>You must set the ayah query
                    parameter to true in order for this parameter to work.</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">translations</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Load all of the
                    translations for that ayah.</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[true, false]</p>
                <p class="ml-6"><span class="font-medium text-green-400">Notes: </span>You must set the ayah query
                    parameter to true in order for this parameter to work.</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">translation_fields</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Comma separated value
                    of the translation fields that are required by the user if the user only want to retrieve some of
                    the translation fields. (e.g. Id,Text, ...)</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[Id, Translation
                    Info Id, Surah Id, Ayah Index, Ayah Key, Text]</p>
                <p class="ml-6"><span class="font-medium text-green-400">Notes: </span>You must set the ayah and
                    translations query parameters to true in order for this parameter to work.</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">translation_info</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Load the translation
                    info of the translation.</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[true, false]</p>
                <p class="ml-6"><span class="font-medium text-green-400">Notes: </span>You must set ayah and
                    translations query parameters to true in order for this parameter to work.</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">translation_info_fields</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Comma separated value
                    of the translation info fields that are required by the user if the user only want to retrieve some
                    of the translation info fields. (e.g. Id,Name, ...)</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[Id, Name,
                    Translator, Language]</p>
                <p class="ml-6"><span class="font-medium text-green-400">Notes: </span>You must set the ayah,
                    translations and translation_info query parameters to true in order for this parameter to work.</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">tafseers</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Load all of the
                    tafseers for that ayah.</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[true, false]</p>
                <p class="ml-6"><span class="font-medium text-green-400">Notes: </span>You must set ayah query
                    parameter to true in order for this parameter to work.</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">tafseer_fields</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Comma separated value
                    of the tafseer fields that are required by the user if the user only want to retrieve some of the
                    tafseer fields. (e.g. Id,Html, ...)</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[Id, Tafseer Info
                    Id, Surah Id, Ayah Index, Ayah Key, Html]</p>
                <p class="ml-6"><span class="font-medium text-green-400">Notes: </span>You must set the ayah and
                    tafseers query parameters to true in order for this parameter to work.</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">tafseer_info</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Load the tafseer info
                    of the tafseer.</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[true, false]</p>
                <p class="ml-6"><span class="font-medium text-green-400">Notes: </span>You must set the ayah and
                    tafseers query parameters to true in order for this parameter to work.</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">tafseer_info_fields</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Comma separated value
                    of the tafseer info fields that are required by the user if the user only want to retrieve some of
                    the tafseer info fields. (e.g. Id,Name, ...)</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[Id, Name, Author
                    Name, Slug, Language Name, Translated Name]</p>
                <p class="ml-6"><span class="font-medium text-green-400">Notes: </span>You must set the ayah,
                    tafseers and tafseer_info query parameters to true in order for this parameter to work.</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">audio_recitations</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Load all of the audio
                    recitations for that ayah.</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[true, false]</p>
                <p class="ml-6"><span class="font-medium text-green-400">Notes: </span>You must set ayah query
                    parameter to true in order for this parameter to work.</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">audio_recitation_fields</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Comma separated value
                    of the audio recitation fields that are required by the user if the user only want to retrieve some
                    of the audio recitation fields. (e.g. Id,Audio Url, ...)</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[Id, Audio Info Id,
                    Surah Id]</p>
                <p class="ml-6"><span class="font-medium text-green-400">Notes: </span>You must set the ayah and
                    audio_recitations query parameters to true in order for this parameter to work.</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">audio_recitation_info</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Load the audio
                    recitation info of the audio recitation.</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[true, false]</p>
                <p class="ml-6"><span class="font-medium text-green-400">Notes: </span>You must set the ayah and
                    audio_recitations query parameters to true in order for this parameter to work.</p>
            </div>
            <div class="my-5">
                <p class="rounded-md px-2 inline-block font-medium text-green-400">audio_recitation_info_fields</p>
                <p class="ml-6"><span class="font-medium text-green-400">Description: </span>Comma separated value
                    of the audio recitation info fields that are required by the user if the user only want to retrieve
                    some of the audio recitation info fields. (e.g. Id,Reciter Name, ...)</p>
                <p class="ml-6"><span class="font-medium text-green-400">Possible values: </span>[Id, Reciter Name,
                    Style, Translated Name]</p>
                <p class="ml-6"><span class="font-medium text-green-400">Notes: </span>You must set the ayah,
                    audio_recitations and audio_recitation_info query parameters to true in order for this parameter to
                    work.</p>
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
        <div x-show="responseOpen" x-transition class="my-2 ml-6" x-data="{ surahOpen: false, surahInfoOpen: false, ayahOpen: false, wordOpen: false, translationInfoOpen: false, translationOpen: false, tafseerInfoOpen: false, tafseerOpen: false, audioRecitationInfoOpen: false, audioRecitationOpen: false, audioRecitationInfoTranslatedNameOpen: false, tafseerInfoTranslatedNameOpen: false }">
            <div @click="wordOpen = !wordOpen"
                class="cursor-pointer rounded-md flex gap-3 items-center text-green-400 ml-6">
                <svg :class="{ 'rotate-90': wordOpen, 'rotate-0': !wordOpen }" x-transition
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                    stroke="currentColor" class="size-4 transition-transform duration-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                <p class="rounded-md px-2 inline-block font-medium">Word <span
                        class="font-normal text-gray-400">object</span></p>
            </div>
            <div x-show="wordOpen" x-transition class="ml-6">
                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Id <span
                        class="font-normal text-gray-400">string</span></p>
                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Surah Id <span
                        class="font-normal text-gray-400">string</span></p>
                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Ayah Idex <span
                        class="font-normal text-gray-400">string</span></p>
                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Word Index <span
                        class="font-normal text-gray-400">string</span></p>
                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Ayah Key <span
                        class="font-normal text-gray-400">string</span></p>
                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Word Key <span
                        class="font-normal text-gray-400">string</span></p>
                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Audio Url <span
                        class="font-normal text-gray-400">string</span></p>
                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Page Id <span
                        class="font-normal text-gray-400">string</span></p>
                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Line Number <span
                        class="font-normal text-gray-400">string</span></p>
                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Text <span
                        class="font-normal text-gray-400">string</span></p>
                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Characters <span
                        class="font-normal text-gray-400">array</span></p>
                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Translation <span
                        class="font-normal text-gray-400">string</span></p>
                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Transliteration <span
                        class="font-normal text-gray-400">string</span></p>
                <div @click="surahOpen = !surahOpen"
                    class="cursor-pointer rounded-md flex gap-3 items-center text-green-400 ml-6">
                    <svg :class="{ 'rotate-90': surahOpen, 'rotate-0': !surahOpen }" x-transition
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                        stroke="currentColor" class="size-4 transition-transform duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                    <p class="rounded-md px-2 inline-block font-medium">Surah <span
                            class="font-normal text-gray-400">object</span></p>
                </div>
                <div x-show="surahOpen" x-transition class="ml-6">
                    <p class="rounded-md px-2 font-medium text-green-400 ml-6">Id <span
                            class="font-normal text-gray-400">string</span></p>
                    <p class="rounded-md px-2 font-medium text-green-400 ml-6">Arabic Name <span
                            class="font-normal text-gray-400">string</span></p>
                    <p class="rounded-md px-2 font-medium text-green-400 ml-6">Name <span
                            class="font-normal text-gray-400">string</span></p>
                    <p class="rounded-md px-2 font-medium text-green-400 ml-6">Name Meaning <span
                            class="font-normal text-gray-400">string</span></p>
                    <p class="rounded-md px-2 font-medium text-green-400 ml-6">Type <span
                            class="font-normal text-gray-400">string</span></p>
                    <p class="rounded-md px-2 font-medium text-green-400 ml-6">Number of Ayahs <span
                            class="font-normal text-gray-400">integer</span></p>
                    <div @click="surahInfoOpen = !surahInfoOpen"
                        class="cursor-pointer rounded-md flex gap-3 items-center text-green-400 ml-6">
                        <svg :class="{ 'rotate-90': surahInfoOpen, 'rotate-0': !surahInfoOpen }" x-transition
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                            stroke="currentColor" class="size-4 transition-transform duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                        <p class="rounded-md px-2 inline-block font-medium">Surah Info <span
                                class="font-normal text-gray-400">object</span></p>
                    </div>
                    <div x-show="surahInfoOpen" x-transition class="ml-6">
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Id <span
                                class="font-normal text-gray-400">string</span></p>
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Html <span
                                class="font-normal text-gray-400">string</span></p>
                    </div>
                </div>
                <div @click="ayahOpen = !ayahOpen"
                    class="cursor-pointer rounded-md flex gap-3 items-center text-green-400 ml-6">
                    <svg :class="{ 'rotate-90': ayahOpen, 'rotate-0': !ayahOpen }" x-transition
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                        stroke="currentColor" class="size-4 transition-transform duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                    <p class="rounded-md px-2 inline-block font-medium">Ayah <span
                            class="font-normal text-gray-400">object</span></p>
                </div>
                <div x-show="ayahOpen" x-transition class="ml-6">
                    <p class="rounded-md px-2 font-medium text-green-400 ml-6">Id <span
                            class="font-normal text-gray-400">string</span></p>
                    <p class="rounded-md px-2 font-medium text-green-400 ml-6">Surah Id <span
                            class="font-normal text-gray-400">string</span></p>
                    <p class="rounded-md px-2 font-medium text-green-400 ml-6">Ayah Index <span
                            class="font-normal text-gray-400">string</span></p>
                    <p class="rounded-md px-2 font-medium text-green-400 ml-6">Ayah Key <span
                            class="font-normal text-gray-400">string</span></p>
                    <p class="rounded-md px-2 font-medium text-green-400 ml-6">Page Id <span
                            class="font-normal text-gray-400">string</span></p>
                    <p class="rounded-md px-2 font-medium text-green-400 ml-6">Juz Id <span
                            class="font-normal text-gray-400">string</span></p>
                    <p class="rounded-md px-2 font-medium text-green-400 ml-6">Bismillah <span
                            class="font-normal text-gray-400">string</span></p>
                    <div @click="translationOpen = !translationOpen"
                        class="cursor-pointer rounded-md flex gap-3 items-center text-green-400 ml-6">
                        <svg :class="{ 'rotate-90': translationOpen, 'rotate-0': !translationOpen }" x-transition
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                            stroke="currentColor" class="size-4 transition-transform duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                        <p class="rounded-md px-2 inline-block font-medium">Translation <span
                                class="font-normal text-gray-400">object</span></p>
                    </div>
                    <div x-show="translationOpen" x-transition class="ml-6">
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Id <span
                                class="font-normal text-gray-400">string</span></p>
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Translation Info Id <span
                                class="font-normal text-gray-400">string</span></p>
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Surah Id <span
                                class="font-normal text-gray-400">string</span></p>
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Ayah Index <span
                                class="font-normal text-gray-400">string</span></p>
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Ayah Key <span
                                class="font-normal text-gray-400">string</span></p>
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Text <span
                                class="font-normal text-gray-400">string</span></p>
                        <div @click="translationInfoOpen = !translationInfoOpen"
                            class="cursor-pointer rounded-md flex gap-3 items-center text-green-400 ml-6">
                            <svg :class="{ 'rotate-90': translationInfoOpen, 'rotate-0': !translationInfoOpen }"
                                x-transition xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="3.5" stroke="currentColor"
                                class="size-4 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                            <p class="rounded-md px-2 inline-block font-medium">Translation Info <span
                                    class="font-normal text-gray-400">object</span></p>
                        </div>
                        <div x-show="translationInfoOpen" x-transition class="ml-6">
                            <p class="rounded-md px-2 font-medium text-green-400 ml-6">Id <span
                                    class="font-normal text-gray-400">string</span></p>
                            <p class="rounded-md px-2 font-medium text-green-400 ml-6">Name <span
                                    class="font-normal text-gray-400">string</span></p>
                            <p class="rounded-md px-2 font-medium text-green-400 ml-6">Translator <span
                                    class="font-normal text-gray-400">string</span></p>
                            <p class="rounded-md px-2 font-medium text-green-400 ml-6">Language <span
                                    class="font-normal text-gray-400">string</span></p>
                        </div>
                    </div>
                    <div @click="tafseerOpen = !tafseerOpen"
                        class="cursor-pointer rounded-md flex gap-3 items-center text-green-400 ml-6">
                        <svg :class="{ 'rotate-90': tafseerOpen, 'rotate-0': !tafseerOpen }" x-transition
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                            stroke="currentColor" class="size-4 transition-transform duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                        <p class="rounded-md px-2 inline-block font-medium">Tafseer <span
                                class="font-normal text-gray-400">object</span></p>
                    </div>
                    <div x-show="tafseerOpen" x-transition class="ml-6">
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Id <span
                                class="font-normal text-gray-400">string</span></p>
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Tafseer Info Id <span
                                class="font-normal text-gray-400">string</span></p>
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Surah Id <span
                                class="font-normal text-gray-400">string</span></p>
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Ayah Index <span
                                class="font-normal text-gray-400">string</span></p>
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Ayah Key <span
                                class="font-normal text-gray-400">string</span></p>
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Html <span
                                class="font-normal text-gray-400">string</span></p>
                        <div @click="tafseerInfoOpen = !tafseerInfoOpen"
                            class="cursor-pointer rounded-md flex gap-3 items-center text-green-400 ml-6">
                            <svg :class="{ 'rotate-90': tafseerInfoOpen, 'rotate-0': !tafseerInfoOpen }" x-transition
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="3.5" stroke="currentColor"
                                class="size-4 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                            <p class="rounded-md px-2 inline-block font-medium">Tafseer Info <span
                                    class="font-normal text-gray-400">object</span></p>
                        </div>
                        <div x-show="tafseerInfoOpen" x-transition class="ml-6">
                            <p class ="rounded-md px-2 font-medium
                            text-green-400 ml-6">Id
                                <span class="font-normal text-gray-400">string</span>
                            </p>
                            <p class="rounded-md px-2 font-medium text-green-400 ml-6">Name <span
                                    class="font-normal text-gray-400">string</span></p>
                            <p class="rounded-md px-2 font-medium text-green-400 ml-6">Author Name <span
                                    class="font-normal text-gray-400">string</span></p>
                            <p class="rounded-md px-2 font-medium text-green-400 ml-6">Slug <span
                                    class="font-normal text-gray-400">string</span></p>
                            <p class="rounded-md px-2 font-medium text-green-400 ml-6">Language Name <span
                                    class="font-normal text-gray-400">string</span></p>
                            <div @click="tafseerInfoTranslatedNameOpen = !tafseerInfoTranslatedNameOpen"
                                class="cursor-pointer rounded-md flex gap-3 items-center text-green-400 ml-6">
                                <svg :class="{
                                    'rotate-90': tafseerInfoTranslatedNameOpen,
                                    'rotate-0': !
                                        tafseerInfoTranslatedNameOpen
                                }"
                                    x-transition xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor"
                                    class="size-4 transition-transform duration-300">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                                <p class="rounded-md px-2 inline-block font-medium">Translated Name <span
                                        class="font-normal text-gray-400">object</span></p>
                            </div>
                            <div x-show="tafseerInfoTranslatedNameOpen" x-transition class="ml-6">
                                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Name <span
                                        class="font-normal text-gray-400">string</span></p>
                                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Language Name <span
                                        class="font-normal text-gray-400">string</span></p>
                            </div>
                        </div>
                    </div>
                    <div @click="audioRecitationOpen = !audioRecitationOpen"
                        class="cursor-pointer rounded-md flex gap-3 items-center text-green-400 ml-6">
                        <svg :class="{ 'rotate-90': audioRecitationOpen, 'rotate-0': !audioRecitationOpen }"
                            x-transition xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="3.5" stroke="currentColor"
                            class="size-4 transition-transform duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                        <p class="rounded-md px-2 inline-block font-medium">Audio Recitation <span
                                class="font-normal text-gray-400">object</span></p>
                    </div>
                    <div x-show="audioRecitationOpen" x-transition class="ml-6">
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Id <span
                                class="font-normal text-gray-400">string</span></p>
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Audio Info Id <span
                                class="font-normal text-gray-400">string</span></p>
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Surah Id <span
                                class="font-normal text-gray-400">string</span></p>
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Ayah Index <span
                                class="font-normal text-gray-400">string</span></p>
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Ayah Key <span
                                class="font-normal text-gray-400">string</span></p>
                        <p class="rounded-md px-2 font-medium text-green-400 ml-6">Audio Url <span
                                class="font-normal text-gray-400">string</span></p>
                        <div @click="audioRecitationInfoOpen = !audioRecitationInfoOpen"
                            class="cursor-pointer rounded-md flex gap-3 items-center text-green-400 ml-6">
                            <svg :class="{ 'rotate-90': audioRecitationInfoOpen, 'rotate-0': !audioRecitationInfoOpen }"
                                x-transition xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="3.5" stroke="currentColor"
                                class="size-4 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                            <p class="rounded-md px-2 inline-block font-medium">Audio Recitation Info <span
                                    class="font-normal text-gray-400">object</span></p>
                        </div>
                        <div x-show="audioRecitationInfoOpen" x-transition class="ml-6">
                            <p class="rounded-md px-2 font-medium text-green-400 ml-6">Id <span
                                    class="font-normal text-gray-400">string</span></p>
                            <p class="rounded-md px-2 font-medium text-green-400 ml-6">Reciter Name <span
                                    class="font-normal text-gray-400">string</span></p>
                            <p class="rounded-md px-2 font-medium text-green-400 ml-6">Style <span
                                    class="font-normal text-gray-400">string</span></p>
                            <div @click="audioRecitationInfoTranslatedNameOpen = !audioRecitationInfoTranslatedNameOpen"
                                class="cursor-pointer rounded-md flex gap-3 items-center text-green-400 ml-6">
                                <svg :class="{
                                    'rotate-90': audioRecitationInfoTranslatedNameOpen,
                                    'rotate-0': !
                                        audioRecitationInfoTranslatedNameOpen
                                }"
                                    x-transition xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor"
                                    class="size-4 transition-transform duration-300">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                                <p class="rounded-md px-2 inline-block font-medium">Translated Name <span
                                        class="font-normal text-gray-400">object</span></p>
                            </div>
                            <div x-show="audioRecitationInfoTranslatedNameOpen" x-transition class="ml-6">
                                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Name <span
                                        class="font-normal text-gray-400">string</span></p>
                                <p class="rounded-md px-2 font-medium text-green-400 ml-6">Language Name <span
                                        class="font-normal text-gray-400">string</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
