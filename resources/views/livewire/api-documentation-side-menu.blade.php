<div class="recitation-side-menu mt-32 h-screen sticky top-0 w-1/3"
x-data="{activeApiDocumentationOption: 'introduction'}"
@set-active-api-documentation-option.window="activeApiDocumentationOption = $event.detail">
    <div class="overflow-y-auto">
        <div class="text-white flex flex-col gap-5 font-sans mx-5 px-5 py-5">
            <div :class="{'text-green-400': activeApiDocumentationOption === 'introduction'}" class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium" @click="$dispatch('set-active-api-documentation-option', 'introduction')">Introduction
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                  </svg>
            </div>
            <div :class="{'text-green-400': activeApiDocumentationOption === 'surah'}" class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium" @click="$dispatch('set-active-api-documentation-option', 'surah')">Surah
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                  </svg>
            </div>
            <div :class="{'text-green-400': activeApiDocumentationOption === 'surah_info'}" class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium" @click="$dispatch('set-active-api-documentation-option', 'surah_info')">Surah Info
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                  </svg>
            </div>
            <div :class="{'text-green-400': activeApiDocumentationOption === 'ayah'}" class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium" @click="$dispatch('set-active-api-documentation-option', 'ayah')">Ayah
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                  </svg>
            </div>
            <div :class="{'text-green-400': activeApiDocumentationOption === 'word'}" class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium" @click="$dispatch('set-active-api-documentation-option', 'word')">Word
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                  </svg>
            </div>
            <div :class="{'text-green-400': activeApiDocumentationOption === 'page'}" class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium" @click="$dispatch('set-active-api-documentation-option', 'page')">Page
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                  </svg>
            </div>
            <div :class="{'text-green-400': activeApiDocumentationOption === 'juz'}" class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium" @click="$dispatch('set-active-api-documentation-option', 'juz')">Juz
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                  </svg>
            </div>
            <div :class="{'text-green-400': activeApiDocumentationOption === 'translation_info'}" class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium" @click="$dispatch('set-active-api-documentation-option', 'translation_info')">Translation Info
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                  </svg>
            </div>
            <div :class="{'text-green-400': activeApiDocumentationOption === 'translation'}" class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium" @click="$dispatch('set-active-api-documentation-option', 'translation')">Translation
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                  </svg>
            </div>
            <div :class="{'text-green-400': activeApiDocumentationOption === 'tafseer_info'}" class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium" @click="$dispatch('set-active-api-documentation-option', 'tafseer_info')">Tafseer Info
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                  </svg>
            </div>
            <div :class="{'text-green-400': activeApiDocumentationOption === 'tafseer'}" class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium" @click="$dispatch('set-active-api-documentation-option', 'tafseer')">Tafseer
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                  </svg>
            </div>
            <div :class="{'text-green-400': activeApiDocumentationOption === 'audio_recitation_info'}" class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium" @click="$dispatch('set-active-api-documentation-option', 'audio_recitation_info')">Audio Recitation Info
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                  </svg>
            </div>
            <div :class="{'text-green-400': activeApiDocumentationOption === 'audio_recitation'}" class="w-full transition ease-in-out duration-150 flex justify-between items-center hover:cursor-pointer hover:bg-gray-500 px-5 font-medium" @click="$dispatch('set-active-api-documentation-option', 'audio_recitation')">Audio Recitation
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                  </svg>
            </div>
        </div>
    </div>
</div>
