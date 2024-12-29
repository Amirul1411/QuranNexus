<x-app-layout title="Quran Analysis">
    <x-slot name="header">
        <div class="flex flex-col justify-center items-center mt-40 gap-8">
            <p class="text-5xl font-serif font-bold text-white">{{ __('quran_analysis.title') }}</p>
        </div>
    </x-slot>
    <div class="my-24 mx-20 w-full" x-data="{ quranAnalysisActiveOption: $persist('') }">
        <div class="flex gap-2 justify-center my-5">
            <x-button borderColor="border-gray-300" bg="bg-gray-200" text="text-gray-800" activeBg="bg-gray-300"
                hover="bg-white" focus="bg-white" focusRingOffset="ring-offset-gray-800"
                @click="quranAnalysisActiveOption = 'chaptersInitials'">
                {{ __('quran_analysis.chapters_initials') }}
            </x-button>
            <x-button borderColor="border-gray-300" bg="bg-gray-200" text="text-gray-800" activeBg="bg-gray-300"
                hover="bg-white" focus="bg-white" focusRingOffset="ring-offset-gray-800"
                @click="quranAnalysisActiveOption = 'characterFrequency'">
                {{ __('quran_analysis.character_frequency') }}
            </x-button>
            <x-button borderColor="border-gray-300" bg="bg-gray-200" text="text-gray-800" activeBg="bg-gray-300"
                hover="bg-white" focus="bg-white" focusRingOffset="ring-offset-gray-800"
                @click="quranAnalysisActiveOption = 'longestToken'">
                {{ __('quran_analysis.longest_token') }}
            </x-button>
            <x-button borderColor="border-gray-300" bg="bg-gray-200" text="text-gray-800" activeBg="bg-gray-300"
                hover="bg-white" focus="bg-white" focusRingOffset="ring-offset-gray-800"
                @click="quranAnalysisActiveOption = 'verseCount'">
                {{ __('quran_analysis.verse_count') }}
            </x-button>
            <x-button borderColor="border-gray-300" bg="bg-gray-200" text="text-gray-800" activeBg="bg-gray-300"
                hover="bg-white" focus="bg-white" focusRingOffset="ring-offset-gray-800"
                @click="quranAnalysisActiveOption = 'diacriticFrequency'">
                {{ __('quran_analysis.diacritic_frequency') }}
            </x-button>
            {{-- <x-button borderColor="border-gray-300" bg="bg-gray-200" text="text-gray-800" activeBg="bg-gray-300"
                hover="bg-white" focus="bg-white" focusRingOffset="ring-offset-gray-800"
                @click="quranAnalysisActiveOption = 'irab'">
                {{ __('quran_analysis.irab') }}
            </x-button> --}}
        </div>

        <template x-if=" quranAnalysisActiveOption === 'chaptersInitials' ">
            @livewire('chapters-initials')
        </template>
        <template x-if=" quranAnalysisActiveOption === 'characterFrequency' ">
            @livewire('character-frequency')
        </template>
        <template x-if=" quranAnalysisActiveOption === 'longestToken' ">
            @livewire('longest-token')
        </template>
        <template x-if=" quranAnalysisActiveOption === 'verseCount' ">
            @livewire('verse-count')
        </template>
        <template x-if=" quranAnalysisActiveOption === 'diacriticFrequency' ">
            @livewire('diacritic-frequency')
        </template>
        {{-- <template x-if=" quranAnalysisActiveOption === 'irab' "> --}}
            {{-- @livewire('irab') --}}
        {{-- </template> --}}
    </div>
</x-app-layout>
