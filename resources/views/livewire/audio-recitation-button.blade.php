<div class="flex justify-end items-center my-5 text-white">
    @if (Route::is('surah.show'))
        <div wire:click="playAudioRecitation({{ $surah->ayahs }})" class="flex w-auto items-center cursor-pointer">
            <span class="mr-1 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" class="size-5">
                    <path
                        d="M6.3 2.84A1.5 1.5 0 0 0 4 4.11v11.78a1.5 1.5 0 0 0 2.3 1.27l9.344-5.891a1.5 1.5 0 0 0 0-2.538L6.3 2.841Z" />
                </svg>
            </span>
            <p class="cursor-pointer">{{ __('recitation.play_audio') }}</p>
        </div>
    @elseif (Route::is('page.show'))
        <div wire:click="playAudioRecitation({{ $page->ayahs }})" class="flex w-auto items-center cursor-pointer">
            <span class="mr-1 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" class="size-5">
                    <path
                        d="M6.3 2.84A1.5 1.5 0 0 0 4 4.11v11.78a1.5 1.5 0 0 0 2.3 1.27l9.344-5.891a1.5 1.5 0 0 0 0-2.538L6.3 2.841Z" />
                </svg>
            </span>
            <p class="cursor-pointer">{{ __('recitation.play_audio') }}</p>
        </div>
    @elseif (Route::is('juz.show'))
        <div wire:click="playAudioRecitation({{ $juz->ayahs }})" class="flex w-auto items-center cursor-pointer">
            <span class="mr-1 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" class="size-5">
                    <path
                        d="M6.3 2.84A1.5 1.5 0 0 0 4 4.11v11.78a1.5 1.5 0 0 0 2.3 1.27l9.344-5.891a1.5 1.5 0 0 0 0-2.538L6.3 2.841Z" />
                </svg>
            </span>
            <p class="cursor-pointer">{{ __('recitation.play_audio') }}</p>
        </div>
    @endif
    <!-- Display the audio player if audio files are present -->
    @if (!empty($audioFiles))
        <div>
            @foreach ($audioFiles as $audioFile)
                <audio controls>
                    <source src="{{ asset($audioFile) }}" type="audio/mpeg" autoplay>
                </audio>
            @endforeach
        </div>
    @endif
</div>
