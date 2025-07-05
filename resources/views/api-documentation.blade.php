<x-app-layout title="API Documentation">
    <x-slot name="header">
        <div class="flex flex-col justify-center items-center mt-40 gap-8">
            <p class="text-5xl font-serif font-bold text-black">{{ __('api_documentation.header_title') }}</p>
        </div>
    </x-slot>
    <x-slot name="leftSideMenu">
        @livewire('api-documentation-side-menu')
    </x-slot>
    <div class="w-full mx-32 mt-32 py-5 text-black font-normal" x-data="{ activeApiDocumentationOption: 'introduction'}"
        @set-active-api-documentation-option.window="activeApiDocumentationOption = $event.detail">
        <template x-if="activeApiDocumentationOption === 'introduction'">
            @include('introduction-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'surah'">
            @include('surah-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'surah_info'">
            @include('surah-info-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'ayah'">
            @include('ayah-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'word'">
            @include('word-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'page'">
            @include('page-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'juz'">
            @include('juz-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'translation_info'">
            @include('translation-info-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'translation'">
            @include('translation-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'tafseer_info'">
            @include('tafseer-info-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'tafseer'">
            @include('tafseer-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'audio_recitation_info'">
            @include('audio-recitation-info-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'audio_recitation'">
            @include('audio-recitation-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'chapters_initials'">
            @include('chapters-initials-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'character_frequency'">
            @include('character-frequency-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'diacritic_frequency'">
            @include('diacritic-frequency-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'longest_token'">
            @include('longest-token-api')
        </template>
        <template x-if="activeApiDocumentationOption === 'word_statistics'">
            @include('word-statistics-api')
        </template>
    </div>
</x-app-layout>
