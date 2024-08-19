<div class="font-BorderIslamic text-white">
    m 
    @foreach ($page->ayahs as $ayah)
        @if ($ayah->ayah_index == 1 && $ayah->bismillah)
            <div class="text-center text-white text-4xl font-basmalah h-24">
                l
            </div>
        @endif
        <div class="text-right text-white font-serif text-2xl my-10 mx-1">{{ $ayah->text }}</div>
    @endforeach
    <h3 class="text-center text-white text-lg font-serif">
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
                </span>Previous page</x-button>
        @endif
        @if ($page->_id != 114)
            <x-button wire:click='redirectToNextPage({{ $page->_id }})'
                class="btn px-4 text-black rounded dark:bg-blue-300 dark:font-bold border-0 mx-6 py-2 flex items-center w-52 justify-center font-serif">Next
                page<span class="ms-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </span>
            </x-button>
        @endif
    </div>
</div>
