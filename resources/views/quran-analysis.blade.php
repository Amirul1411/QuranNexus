<x-app-layout title="Quran Analysis">
    <x-slot name="header">
        <div class="flex flex-col justify-center items-center mt-40 gap-8">
            <p class="text-5xl font-serif font-bold text-white">{{ __('quran_analysis.title') }}</p>
        </div>
    </x-slot>
    <div class="my-24 mx-20 w-full" x-data="{ 
        quranAnalysisActiveOption: $persist(''),
        loadedComponents: new Set()
    }">
        <div class="flex gap-2 justify-center my-5">
            <x-button :class="{'text-green-400': quranAnalysisActiveOption === 'chaptersInitials'}" 
                borderColor="border-gray-300" bg="bg-gray-200" text="text-gray-800" activeBg="bg-gray-300"
                hover="bg-white" focus="bg-white" focusRingOffset="ring-offset-gray-800" 
                class="transform transition-transform duration-300 hover:scale-105"
                @click="quranAnalysisActiveOption = 'chaptersInitials'; loadedComponents.add('chaptersInitials')">
                {{ __('quran_analysis.chapters_initials') }}
            </x-button>
            <x-button :class="{'text-green-400': quranAnalysisActiveOption === 'characterFrequency'}" 
                borderColor="border-gray-300" bg="bg-gray-200" text="text-gray-800" activeBg="bg-gray-300"
                hover="bg-white" focus="bg-white" focusRingOffset="ring-offset-gray-800" 
                class="transform transition-transform duration-300 hover:scale-105"
                @click="quranAnalysisActiveOption = 'characterFrequency'; loadedComponents.add('characterFrequency')">
                {{ __('quran_analysis.character_frequency') }}
            </x-button>
            <x-button :class="{'text-green-400': quranAnalysisActiveOption === 'longestToken'}" 
                borderColor="border-gray-300" bg="bg-gray-200" text="text-gray-800" activeBg="bg-gray-300"
                hover="bg-white" focus="bg-white" focusRingOffset="ring-offset-gray-800" 
                class="transform transition-transform duration-300 hover:scale-105"
                @click="quranAnalysisActiveOption = 'longestToken'; loadedComponents.add('longestToken')">
                {{ __('quran_analysis.longest_token') }}
            </x-button>
            <x-button :class="{'text-green-400': quranAnalysisActiveOption === 'surahAnalysis'}" 
                borderColor="border-gray-300" bg="bg-gray-200" text="text-gray-800" activeBg="bg-gray-300"
                hover="bg-white" focus="bg-white" focusRingOffset="ring-offset-gray-800" 
                class="transform transition-transform duration-300 hover:scale-105"
                @click="quranAnalysisActiveOption = 'surahAnalysis'; loadedComponents.add('surahAnalysis')">
                {{ __('quran_analysis.surah_analysis') }}
            </x-button>
            <x-button :class="{'text-green-400': quranAnalysisActiveOption === 'diacriticFrequency'}" 
                borderColor="border-gray-300" bg="bg-gray-200" text="text-gray-800" activeBg="bg-gray-300"
                hover="bg-white" focus="bg-white" focusRingOffset="ring-offset-gray-800" 
                class="transform transition-transform duration-300 hover:scale-105"
                @click="quranAnalysisActiveOption = 'diacriticFrequency'; loadedComponents.add('diacriticFrequency')">
                {{ __('quran_analysis.diacritic_frequency') }}
            </x-button>
            <x-button :class="{'text-green-400': quranAnalysisActiveOption === 'wordStatistics'}" 
                borderColor="border-gray-300" bg="bg-gray-200" text="text-gray-800" activeBg="bg-gray-300"
                hover="bg-white" focus="bg-white" focusRingOffset="ring-offset-gray-800" 
                class="transform transition-transform duration-300 hover:scale-105"
                @click="quranAnalysisActiveOption = 'wordStatistics'; loadedComponents.add('wordStatistics')">
                {{ __('quran_analysis.word_statistics') }}
            </x-button>
        </div>

        <!-- Loading indicator for when switching tabs -->
        <div x-show="quranAnalysisActiveOption && !loadedComponents.has(quranAnalysisActiveOption)" 
             class="flex justify-center items-center py-20">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-400"></div>
        </div>

        <!-- Lazy-loaded components -->
        <template x-if="quranAnalysisActiveOption === 'chaptersInitials' && loadedComponents.has('chaptersInitials')">
            @livewire('chapters-initials', key('chapters-initials'))
        </template>
        <template x-if="quranAnalysisActiveOption === 'characterFrequency' && loadedComponents.has('characterFrequency')">
            @livewire('character-frequency', key('character-frequency'))
        </template>
        <template x-if="quranAnalysisActiveOption === 'longestToken' && loadedComponents.has('longestToken')">
            @livewire('longest-token', key('longest-token'))
        </template>
        <template x-if="quranAnalysisActiveOption === 'surahAnalysis' && loadedComponents.has('surahAnalysis')">
            @livewire('surah-analysis', key('surah-analysis'))
        </template>
        <template x-if="quranAnalysisActiveOption === 'diacriticFrequency' && loadedComponents.has('diacriticFrequency')">
            @livewire('diacritic-frequency', key('diacritic-frequency'))
        </template>
        <template x-if="quranAnalysisActiveOption === 'wordStatistics' && loadedComponents.has('wordStatistics')">
            @livewire('word-statistics', key('word-statistics'))
        </template>

        <!-- Default message when no tab is selected -->
        <div x-show="!quranAnalysisActiveOption" class="text-center py-20">
            <p class="text-xl text-gray-600">{{ __('quran_analysis.select_analysis_type') }}</p>
        </div>
    </div>
</x-app-layout>
