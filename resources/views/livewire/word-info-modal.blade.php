<x-dialog-modal id="word-info-modal" maxWidth="md" wire:model.live="show" darkBg="bg-white" footerPosition="text-center"
    footerJustify="justify-center" footerItems="items-start" footerPaddingY='pb-4'>

    <x-slot name="title">
        <h2 class="text-center text-3xl my-5 text-black font-bold">Word Info</h2>
        <div class="flex justify-end text-black me-5">
            @if ($wordStatistics != null && $firstWordOccurrence != null)
                @livewire('bookmark', [
                    'type' => 'word',
                    'itemProperties' => [
                        'word_statistics_id' => $wordStatistics->_id,
                        'word_text' => $wordStatistics->word,
                        'translation' => $wordStatistics->translation,
                        'transliteration' => $wordStatistics->transliteration,
                        'total_occurrences' => $wordStatistics->total_occurrences,
                        'first_occurrence' => [
                            'word_key' => $firstWordOccurrence->word_key,
                            'chapter_id' => $firstWordOccurrence->surah_id,
                            'verse_number' => $firstWordOccurrence->ayah_index,
                            'surah_name' => $firstWordOccurrence->surah->tname,
                            'page_id' => $firstWordOccurrence->page_id,
                            'juz_id' => $firstWordOccurrence->juz_id,
                            'verse_text' => $firstOccurrenceWordFullVerse,
                            'audio_url' => $firstWordOccurrence->audio_url,
                        ],
                    ],
                ])
            @endif
        </div>
    </x-slot>

    <x-slot name="content">

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4" />

        <div>
            <div class="mt-7 relative w-full">
                @if ($wordStatistics != null)
                    <div>
                        <h2 class="mx-auto my-10 text-5xl font-UthmanicHafs text-black text-center">
                            {{ $wordStatistics->word }}</h2>
                        <div class="my-10 text-black text-base">
                            <p>Translation: {{ $wordStatistics->translation }}</p>
                            <p>Transliteration: {{ $wordStatistics->transliteration }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <x-section-border />

            <div class="mb-7 relative w-full">
                @if ($firstWordOccurrence != null)
                    <div>
                        <h2 class="my-5 font-semibold text-2xl text-black">First Occurrence Details</h2>
                        <div class="my-5 text-black text-base">
                            <p>Surah: <span
                                    class="font-UthmanicHafs text-lg">{{ $firstWordOccurrence->surah->name }}</span></p>
                            <p class="w-full flex items-center gap-2">
                                <span>Full Verse:</span>
                                <span
                                    class="font-UthmanicHafs text-lg rtl-truncate flex-1 text-right">{{ $firstOccurrenceWordFullVerse }}</span>
                            </p>
                            <p>Ayah Key: {{ $firstWordOccurrence->ayah_key }}</p>
                            <p>Page ID: {{ $firstWordOccurrence->page_id }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <x-section-border />

            <div class="mb-7 relative w-full">
                @if ($wordStatistics != null)
                    <div>
                        <h2 class="my-5 font-semibold text-2xl text-black">Distribution Analysis</h2>
                        <div class="my-5 text-black text-base">
                            <p>Total Occurrences: {{ $wordStatistics->total_occurrences }}</p>
                            <p>Most: <span>Juz {{ $highestJuzId }} ({{ $highestCount }})</span>, Least: <span>Juz {{ $leastJuzId }} ({{ $leastCount }}) </span></p>
                        </div>
                        @livewire('word-distribution-analysis-chart', [ 'wordStatistics' => $wordStatistics ])
                    </div>
                @endif
            </div>

            {{-- <div class="flex items-center justify-center mt-4">
                <x-button wire:click="playWordAudioRecitation"
                    bg="bg-gradient-to-r from-light-green via-light-green-teal via-56 to-teal" text="text-black"
                    activeBg="" hover="" focus="" focusRingOffset="" borderWidth="border-0"
                    class="font-serif transform transition-transform duration-300 hover:scale-105">
                    Play Audio
                </x-button>
            </div> --}}
        </div>
    </x-slot>

    <x-slot name="footer">
    </x-slot>
</x-dialog-modal>

{{-- @push('scripts')
    <script>
        // Listen for the 'play-audio' event dispatched by Livewire
        Livewire.on('play-audio', (data) => {
            const audioUrl = data.audioUrl;

            console.log(audioUrl);

            // Create a new Audio object and play the audio
            const audio = new Audio(audioUrl);
            audio.play().catch(error => {
                console.error('Error playing audio:', error);
            });
        });
    </script>
@endpush --}}
