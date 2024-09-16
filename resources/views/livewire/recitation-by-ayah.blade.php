<div>
    @foreach ($surah->ayahs as $ayah)
        @if ($ayah->ayah_index == 1 && $ayah->bismillah)
            <div class="text-center text-white text-4xl font-basmalah h-24">
                l
            </div>
        @endif
        <div class="flex items-center text-white border-b-2 border-gray-200">
            <div class="w-1/12 my-5 aya-side-menu-color text-center flex flex-col justify-center items-center gap-3">
                <p>{{ $surah->_id }}:{{ $ayah->ayah_index }}</p>
                @livewire('bookmark', ['type' => 'ayah', 'item' => $ayah])
                <span wire:click="displayAyahTafseer({{ $surah->_id }}, {{ $ayah->ayah_index }})"
                    class="cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" class="size-5">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                </svg>
            </div>
            <div class="w-11/12 my-3 flex flex-wrap items-center flex-row-reverse gap-2">
                @foreach($ayah->words as $word)
                    <div class="font-UthmanicHafs text-3xl">
                        {{ $word->text }}
                    </div>
                    {{-- <img src="https://static.qurancdn.com/images/w/rq-color/{{ $word->surah_id }}/{{ $word->ayah_index }}/{{ $word->word_index }}.png?v=1" alt="{{ $word->text }}"> --}}
                @endforeach
                <span class="text-3xl font-UthmanicHafs text-white">
                    {{ mapAyahNumberToNumberIcon($ayah->ayah_index) }}
                </span>
                {{-- <p class="text-right text-white text-2xl my-10 font-UthmanicHafs">
                    {{ $aya->text }}
                    <span class="text-3xl font-UthmanicHafs text-white">
                        {{ mapAyahNumberToNumberIcon($aya->ayah_index) }}
                    </span>
                </p> --}}
                <p class="text-white my-10">
                        {{ $ayah->translations->text }}
                </p>
            </div>
        </div>
    @endforeach

    <div class="flex justify-center my-10 mx-auto">
        @if ($surah->_id != 1)
            <x-button wire:click='redirectToPreviousSurah({{ $surah->_id }})'
                class="btn px-4 text-black rounded dark:bg-blue-300 dark:font-bold border-0 mx-6 py-2 flex items-center w-52 justify-center font-serif"><span
                    class="mr-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </span>Previous surah</x-button>
        @endif
        @if ($surah->_id != 114)
            <x-button wire:click='redirectToNextSurah({{ $surah->_id }})'
                class="btn px-4 text-black rounded dark:bg-blue-300 dark:font-bold border-0 mx-6 py-2 flex items-center w-52 justify-center font-serif">Next
                surah<span class="ms-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </span>
            </x-button>
        @endif
    </div>
</div>
