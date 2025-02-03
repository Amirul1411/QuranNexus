<div>
    @if (Route::is('surah.show'))
        <div x-data="{
            scrollToAyah: '{{ session('scrollToAyah', '') }}',
            highlightToken: '{{ session('highlightToken', '') }}'
        }" x-init="if (scrollToAyah) {
            const ayahElement = document.querySelector('#sa_' + scrollToAyah);
            if (ayahElement) {
                ayahElement.scrollIntoView({ behavior: 'smooth' });
            }
        }
        if (highlightToken) {
            const tokenElement = document.querySelector('#sat_' + highlightToken);
            if (tokenElement) {
                tokenElement.classList.add('bg-yellow-300');
                setTimeout(() => {
                    tokenElement.classList.remove('bg-yellow-300');
                }, 5000); // Remove highlight after 5 seconds
            }
        }">
            @foreach ($ayahs as $ayah)
                @if ($ayah->ayah_index == 1 && $ayah->bismillah)
                    <div class="text-center text-black text-4xl font-basmalah h-24">
                        l
                    </div>
                @endif
                <div id="sa_{{ $surah->_id }}-{{ $ayah->ayah_index }}"
                    class="flex items-center text-black border-b-2 border-gray-200">
                    <div
                        class="w-1/12 my-5 text-black text-center flex flex-col justify-center items-center gap-3">
                        <p>{{ $surah->_id }}:{{ $ayah->ayah_index }}</p>
                        @livewire('bookmark', ['type' => 'ayah', 'itemProperties' => ['surah_id' => $ayah->surah_id, 'ayah_index' => $ayah->ayah_index]])
                        <span wire:click="displayAyahTafseer({{ $ayah->_id }})" class="cursor-pointer transform transition-transform duration-300 hover:scale-125"><svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                        </svg> --}}
                    </div>
                    <div class="w-11/12 my-5 flex flex-col gap-2">
                        <div class="flex flex-wrap items-center flex-row-reverse gap-2 my-5">
                            @foreach ($ayah->words as $word)
                                {{-- Check if it's not the last word of the ayah to differentiate between displaying the word text and ayah icon --}}
                                @if ($word->word_index !== (string) $word->ayah->words->count())
                                    <div id="sat_{{ $surah->_id }}-{{ $ayah->ayah_index }}-{{ $word->word_index }}" wire:click="displayWordInfo('{{ $word->word_key }}')"
                                        class="font-UthmanicHafs text-3xl cursor-pointer transform transition-transform duration-300 hover:scale-105">
                                        {{ $word->text }}
                                    </div>
                                    {{-- <img src="https://static.qurancdn.com/images/w/rq-color/{{ $word->surah_id }}/{{ $word->ayah_index }}/{{ $word->word_index }}.png?v=1" alt="{{ $word->text }}"> --}}
                                @else
                                    <span class="text-3xl font-UthmanicHafs text-black">
                                        {{ $word->text }}
                                    </span>
                                @endif
                            @endforeach

                        </div>
                        <div class="text-black my-5 font-serif font-thin">
                            @if (Auth::guest() || !isset(Auth::user()->settings['translation_id']))
                                {{ $ayah->translations->where('translation_info_id', '1')->first()->text }}
                            @else
                                {{ $ayah->translations->where('translation_info_id', Auth::user()->settings['translation_id'])->first()->text }}
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="my-3 text-black">
                {{ $ayahs->links() }}
            </div>
        </div>


        <div class="flex justify-center my-10 mx-auto">
            @if ($surah->_id != 1)
                <x-button wire:click='redirectToPreviousSurah({{ $surah->_id }})'
                    type="button" bg="bg-[#8EE4FF]" text="text-black" activeBg=""
                                    hover="" focus="" focusRingOffset=""
                                        class="px-4 mx-6 py-2 w-52 text-black cursor-pointer flex items-center justify-center h-auto transform transition-transform duration-300 hover:scale-105"><span
                        class="mr-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </span>{{ __('recitation.previous_surah') }}</x-button>
            @endif
            @if ($surah->_id != 114)
                <x-button wire:click='redirectToNextSurah({{ $surah->_id }})'
                    type="button" bg="bg-[#8EE4FF]" text="text-black" activeBg=""
                                    hover="" focus="" focusRingOffset=""
                                        class="px-4 mx-6 py-2 w-52 text-black cursor-pointer flex items-center justify-center h-auto transform transition-transform duration-300 hover:scale-105">{{ __('recitation.next_surah') }}<span
                        class="ms-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </span>
                </x-button>
            @endif
        </div>
    @elseif (Route::is('page.show'))
        @foreach ($page->ayahs as $ayah)
            @if ($ayah->ayah_index == 1)
                <h3 class="text-center text-black font-light text-9xl mt-6 font-surahnames">
                    {{ mapSurahNumberToSurahFont($ayah->surah->id) }}</h3>
                @if ($ayah->bismillah)
                    <div class="text-center text-black text-4xl font-basmalah h-24">
                        l
                    </div>
                @endif
            @endif
            <div class="flex items-center text-black border-b-2 border-gray-200">
                <div
                    class="w-1/12 my-5 text-black text-center flex flex-col justify-center items-center gap-3">
                    <p>{{ $ayah->surah->_id }}:{{ $ayah->ayah_index }}</p>
                    @livewire('bookmark', ['type' => 'ayah', 'itemProperties' => ['surah_id' => $ayah->surah_id, 'ayah_index' => $ayah->ayah_index]])
                    <span wire:click="displayAyahTafseer({{ $ayah->_id }})" class="cursor-pointer transform transition-transform duration-300 hover:scale-125"><svg
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                    </svg> --}}
                </div>
                <div class="w-11/12 my-5 flex flex-col gap-2">
                    <div class="flex flex-wrap items-center flex-row-reverse gap-2 my-5">
                        @foreach ($ayah->words as $word)
                            {{-- Check if it's not the last word of the ayah to differentiate between displaying the word text and ayah icon --}}
                            @if ($word->word_index !== (string) $word->ayah->words->count())
                                <div class="font-UthmanicHafs text-3xl">
                                    {{ $word->text }}
                                </div>
                                {{-- <img src="https://static.qurancdn.com/images/w/rq-color/{{ $word->surah_id }}/{{ $word->ayah_index }}/{{ $word->word_index }}.png?v=1" alt="{{ $word->text }}"> --}}
                            @else
                                <span class="text-3xl font-UthmanicHafs text-black">
                                    {{ $word->text }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                    <div class="text-black my-5 font-serif font-thin">
                        @if (Auth::guest() || !isset(Auth::user()->settings['translation_id']))
                            {{ $ayah->translations->where('translation_info_id', '1')->first()->text }}
                        @else
                            {{ $ayah->translations->where('translation_info_id', Auth::user()->settings['translation_id'])->first()->text }}
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <h3 class="text-center text-black text-base font-sans my-5">
            {{ $page->_id }}
        </h3>

        <div class="flex justify-center my-10 mx-auto">
            @if ($page->_id != 1)
                <x-button wire:click='redirectToPreviousPage({{ $page->_id }})'
                    type="button" bg="bg-[#8EE4FF]" text="text-black" activeBg=""
                                    hover="" focus="" focusRingOffset=""
                                        class="px-4 mx-6 py-2 w-52 text-black cursor-pointer flex items-center justify-center h-auto transform transition-transform duration-300 hover:scale-105"><span
                        class="mr-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </span>{{ __('recitation.previous_page') }}</x-button>
            @endif
            @if ($page->_id != 604)
                <x-button wire:click='redirectToNextPage({{ $page->_id }})'
                    type="button" bg="bg-[#8EE4FF]" text="text-black" activeBg=""
                                    hover="" focus="" focusRingOffset=""
                                        class="px-4 mx-6 py-2 w-52 text-black cursor-pointer flex items-center justify-center h-auto transform transition-transform duration-300 hover:scale-105">{{ __('recitation.next_page') }}<span
                        class="ms-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </span>
                </x-button>
            @endif
        </div>
    @elseif (Route::is('juz.show'))
        <h3 class="text-center text-black text-base font-sans my-5">
            Juz {{ $juz->_id }}
        </h3>

        @foreach ($ayahs as $ayah)
            @if ($ayah->ayah_index == 1)
                <h3 class="text-center text-black font-light text-9xl mt-6 font-surahnames">
                    {{ mapSurahNumberToSurahFont($ayah->surah->id) }}</h3>
                @if ($ayah->bismillah)
                    <div class="text-center text-black text-4xl font-basmalah h-24">
                        l
                    </div>
                @endif
            @endif
            <div class="flex items-center text-black border-b-2 border-gray-200">
                <div
                    class="w-1/12 my-5 text-black text-center flex flex-col justify-center items-center gap-3">
                    <p>{{ $ayah->surah->_id }}:{{ $ayah->ayah_index }}</p>
                    @livewire('bookmark', ['type' => 'ayah', 'itemProperties' => ['surah_id' => $ayah->surah_id, 'ayah_index' => $ayah->ayah_index]])
                    <span wire:click="displayAyahTafseer({{ $ayah->_id }})" class="cursor-pointer transform transition-transform duration-300 hover:scale-125"><svg
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="size-5">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                    </svg> --}}
                </div>
                <div class="w-11/12 my-5 flex flex-col gap-2">
                    <div class="flex flex-wrap items-center flex-row-reverse gap-2 my-5">
                        @foreach ($ayah->words as $word)
                            {{-- Check if it's not the last word of the ayah to differentiate between displaying the word text and ayah icon --}}
                            @if ($word->word_index !== (string) $word->ayah->words->count())
                                <div class="font-UthmanicHafs text-3xl">
                                    {{ $word->text }}
                                </div>
                                {{-- <img src="https://static.qurancdn.com/images/w/rq-color/{{ $word->surah_id }}/{{ $word->ayah_index }}/{{ $word->word_index }}.png?v=1" alt="{{ $word->text }}"> --}}
                            @else
                                <span class="text-3xl font-UthmanicHafs text-black">
                                    {{ $word->text }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                    <div class="text-black my-5 font-serif font-thin">
                        @if (Auth::guest() || !isset(Auth::user()->settings['translation_id']))
                            {{ $ayah->translations->where('translation_info_id', '1')->first()->text }}
                        @else
                            {{ $ayah->translations->where('translation_info_id', Auth::user()->settings['translation_id'])->first()->text }}
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <div class="my-3 text-black">
            {{ $ayahs->links() }}
        </div>

        <div class="flex justify-center my-10 mx-auto">
            @if ($juz->_id != 1)
                <x-button wire:click='redirectToPreviousJuz({{ $juz->_id }})'
                    type="button" bg="bg-[#8EE4FF]" text="text-black" activeBg=""
                                    hover="" focus="" focusRingOffset=""
                                        class="px-4 mx-6 py-2 w-52 text-black cursor-pointer flex items-center justify-center h-auto transform transition-transform duration-300 hover:scale-105"><span
                        class="mr-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </span>{{ __('recitation.previous_juz') }}</x-button>
            @endif
            @if ($juz->_id != 30)
                <x-button wire:click='redirectToNextJuz({{ $juz->_id }})'
                    type="button" bg="bg-[#8EE4FF]" text="text-black" activeBg=""
                                    hover="" focus="" focusRingOffset=""
                                        class="px-4 mx-6 py-2 w-52 text-black cursor-pointer flex items-center justify-center h-auto transform transition-transform duration-300 hover:scale-105">{{ __('recitation.next_juz') }}<span
                        class="ms-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </span>
                </x-button>
            @endif
        </div>
    @endif
</div>
