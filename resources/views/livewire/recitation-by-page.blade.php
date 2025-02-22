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
                                <h3 class="text-center text-black font-light text-9xl mt-6 font-surahnames">
                                    {{ mapSurahNumberToSurahFont($word->ayah->surah->id) }}
                                </h3>
                            </div>

                            @if ($word->ayah->bismillah)
                                <div class="row-span-1 col-span-15 text-center text-black text-4xl font-basmalah h-24">
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
                        class="row-span-1 flex flex-wrap items-center flex-row-reverse gap-2 my-2 text-black justify-center">
                        @foreach ($words as $word)
                            <div class="inline-block">
                                {{-- Check if it's not the last word of the ayah to differentiate between displaying the word text and ayah icon --}}
                                @if ($word->word_index !== (string) $word->ayah->words->count())
                                    <div wire:click="displayWordInfo('{{ $word->text }}')"
                                        class="font-UthmanicHafs text-3xl cursor-pointer transform transition-transform duration-300 hover:scale-110">
                                        {{ $word->text }}
                                    </div>
                                @else
                                    <span class="text-3xl font-UthmanicHafs text-black">
                                        {{ $word->text }}
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="row-span-1 flex flex-wrap items-center flex-row-reverse gap-2 my-2 text-black justify-between w-3/4 mx-auto">
                        @foreach ($words as $word)
                            <div class="inline-block">
                                {{-- Check if it's not the last word of the ayah to differentiate between displaying the word text and ayah icon --}}
                                @if ($word->word_index !== (string) $word->ayah->words->count())
                                    <div wire:click="displayWordInfo('{{ $word->text }}')"
                                        class="font-UthmanicHafs text-3xl cursor-pointer transform transition-transform duration-300 hover:scale-110">
                                        {{ $word->text }}
                                    </div>
                                @else
                                    <span class="text-3xl font-UthmanicHafs text-black">
                                        {{ $word->text }}
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        @endforeach
    </div>

    <h3 class="text-center text-black text-base font-sans my-5">
        {{ $page->_id }}
    </h3>

    <div class="flex justify-center my-10 mx-auto">
        @if ($page->_id != 1)
            <x-button wire:click='redirectToPreviousPage({{ $page->_id }})' type="button" bg="bg-[#8EE4FF]"
                text="text-black" activeBg="" hover="" focus="" focusRingOffset=""
                class="px-4 mx-6 py-2 w-52 text-black cursor-pointer flex items-center justify-center h-auto transform transition-transform duration-300 hover:scale-105"><span
                    class="mr-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </span>{{ __('recitation.previous_page') }}</x-button>
        @endif
        @if ($page->_id != 604)
            <x-button wire:click='redirectToNextPage({{ $page->_id }})' type="button" bg="bg-[#8EE4FF]"
                text="text-black" activeBg="" hover="" focus="" focusRingOffset=""
                class="px-4 mx-6 py-2 w-52 text-black cursor-pointer flex items-center justify-center h-auto transform transition-transform duration-300 hover:scale-105">{{ __('recitation.next_page') }}<span
                    class="ms-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </span>
            </x-button>
        @endif
    </div>
</div>
