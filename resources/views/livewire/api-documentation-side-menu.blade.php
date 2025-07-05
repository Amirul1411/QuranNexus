<div class="recitation-side-menu mt-32 h-screen sticky top-0 w-1/3 overflow-y-auto" x-data="{ activeApiDocumentationOption: 'introduction' }"
    @set-active-api-documentation-option.window="activeApiDocumentationOption = $event.detail">

    <div class="text-white flex flex-col gap-5 font-sans mx-5 px-5 py-5">
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'introduction' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'introduction')">Introduction
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'surah' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'surah')">Surah
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'surah_info' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'surah_info')">Surah Info
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'ayah' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'ayah')">Ayah
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'word' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'word')">Word
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'page' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'page')">Page
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'juz' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'juz')">Juz
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'translation_info' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'translation_info')">Translation Info
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'translation' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'translation')">Translation
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'tafseer_info' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'tafseer_info')">Tafseer Info
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'tafseer' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'tafseer')">Tafseer
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'audio_recitation_info' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'audio_recitation_info')">Audio Recitation Info
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'audio_recitation' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'audio_recitation')">Audio Recitation
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'chapters_initials' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'chapters_initials')">Chapters Initials
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'character_frequency' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'character_frequency')">Character Frequency
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'diacritic_frequency' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'diacritic_frequency')">Diacritic Frequency
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'longest_token' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'longest_token')">Longest Token
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div :class="{ 'text-green-400': activeApiDocumentationOption === 'word_statistics' }"
            class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium"
            @click="$dispatch('set-active-api-documentation-option', 'word_statistics')">Word Statistics
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
    </div>

</div>
