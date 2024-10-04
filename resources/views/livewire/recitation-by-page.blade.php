<div>
    @php
        // Collect words for each row across all ayahs
        $rows = [];
        foreach ($page->ayahs as $ayah) {
            foreach ($ayah->words as $word) {
                $rowNumber = $word->line_number;
                if (!isset($rows[$rowNumber])) {
                    $rows[$rowNumber] = collect();
                }
                $rows[$rowNumber]->push($word);
            }
        }
    @endphp

    <div class="grid grid-rows-15">
        @php
            $currentSurahId = null; // Keep track of the current Surah
        @endphp

        @foreach ($rows as $rowNumber => $words)
            @if ($words->isNotEmpty())
                @foreach ($words as $word)
                    @if ($currentSurahId !== $word->ayah->surah->id)
                        @if ($word->ayah->ayah_index == 1)
                            {{-- Display the Surah name when a new Surah starts --}}
                            <div class="row-span-1 col-span-15">
                                <h3 class="text-center text-white font-light text-9xl mt-6 font-surahnames">
                                    {{ mapSurahNumberToSurahFont($word->ayah->surah->id) }}
                                </h3>
                            </div>

                            @if ($word->ayah->bismillah)
                                <div class="row-span-1 col-span-15 text-center text-white text-4xl font-basmalah h-24">
                                    l
                                </div>
                            @endif

                            @php
                                $currentSurahId = $word->ayah->surah->id; // Update the current Surah ID
                            @endphp
                        @endif
                    @endif
                @endforeach
                @if ((int) $page->id <= 2)
                    <div
                        class="row-span-1 flex flex-wrap items-center flex-row-reverse gap-2 my-2 text-white justify-center">
                        @foreach ($words as $word)
                            <div class="font-UthmanicHafs text-3xl inline-block">
                                {{ $word->text }}

                                {{-- Check if it's the last word of the ayah to display the ayah icon --}}
                                @if ($word->word_index === (string) $word->ayah->words->count())
                                    <span class="text-3xl font-UthmanicHafs text-white">
                                        {{ mapAyahNumberToNumberIcon($word->ayah->ayah_index) }}
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="row-span-1 flex flex-wrap items-center flex-row-reverse gap-2 my-2 text-white justify-between w-3/4 mx-auto">
                        @foreach ($words as $word)
                            <div class="font-UthmanicHafs text-3xl inline-block">
                                {{ $word->text }}

                                {{-- Check if it's the last word of the ayah to display the ayah icon --}}
                                @if ($word->word_index === (string) $word->ayah->words->count())
                                    <span class="text-3xl font-UthmanicHafs text-white">
                                        {{ mapAyahNumberToNumberIcon($word->ayah->ayah_index) }}
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        @endforeach
    </div>

    <h3 class="text-center text-white text-base font-sans my-5">
        {{ $page->_id }}
    </h3>

    <div class="flex justify-center my-10 mx-auto">
        @if ($page->_id != 1)
            <x-button wire:click='redirectToPreviousPage({{ $page->_id }})'
                class="btn px-4 text-black rounded dark:bg-blue-300 dark:font-bold border-0 mx-6 py-2 flex items-center w-52 justify-center font-serif"><span
                    class="mr-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </span>{{ __('recitation.previous_page') }}</x-button>
        @endif
        @if ($page->_id != 604)
            <x-button wire:click='redirectToNextPage({{ $page->_id }})'
                class="btn px-4 text-black rounded dark:bg-blue-300 dark:font-bold border-0 mx-6 py-2 flex items-center w-52 justify-center font-serif">{{ __('recitation.next_page') }}<span
                    class="ms-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </span>
            </x-button>
        @endif
    </div>
</div>
