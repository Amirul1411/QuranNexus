<x-dialog-modal id="word-info-modal" maxWidth="md" wire:model.live="show" darkBg="bg-white" footerPosition="text-center"
    footerJustify="justify-center" footerItems="items-start" footerPaddingY='pb-4'>

    <x-slot name="title">
        <h2 class="text-center text-3xl my-5 text-black font-bold">Word Info</h2>
        <div class="text-end text-black">
            @if ($word != null)
                @livewire('bookmark', [
                    'type' => 'word',
                    'itemProperties' => [
                        'word_id' => $word->_id,
                        'word_text' => $word->text,
                        'translation' => $word->translation,
                        'transliteration' => $word->transliteration,
                        'surah_name' => $word->surah->tname,
                        'ayah_key' => $word->ayah_key,
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

        {{-- <x-validation-errors class="mb-4" /> --}}

        <div>
            @csrf

            <div class="my-7 relative w-full justify-center flex items-center">
                @if ($word != null)
                    <div>
                        <h2 class="mx-auto my-3 text-5xl font-UthmanicHafs">{{ $word->text }}</h2>
                        <div class="my-3 text-black text-base">
                            <p>Translation: {{ $word->translation }}</p>
                            <p>Transliteration: {{ $word->transliteration }}</p>
                            <p>Surah: {{ $word->surah->tname }}</p>
                            <p>Ayah Key: {{ $word->ayah_key }}</p>
                            <p>Surah Number: {{ $word->surah_id }}</p>
                            <p>Line Number: {{ $word->line_number }}</p>
                            <p>Word Number: {{ $word->word_number }}</p>
                            <p>Page Id: {{ $word->page_id }}</p>
                            <p>Juz Id: {{ $word->juz_id }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-button wire:click="playWordAudioRecitation"
                    bg="bg-gradient-to-r from-light-green via-light-green-teal via-56 to-teal" text="text-black"
                    activeBg="" hover="" focus="" focusRingOffset="" borderWidth="border-0"
                    class="font-serif transform transition-transform duration-300 hover:scale-105">
                    Play Audio
                </x-button>
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
    </x-slot>
</x-dialog-modal>

@script
    <script>
        // Listen for the 'play-audio' event dispatched by Livewire
        $wire.on('play-audio', (data) => {
            const audioUrl = data.audioUrl;

            // Create a new Audio object and play the audio
            const audio = new Audio(audioUrl);
            audio.play().catch(error => {
                console.error('Error playing audio:', error);
            });
        });
    </script>
@endscript
