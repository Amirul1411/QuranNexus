<div class="flex justify-end items-center mt-5">
    <div wire:click="displaySurahDetails({{ $surah->_id }})" class="flex w-auto items-center cursor-pointer transform transition-transform duration-300 hover:scale-125">
        <span wire:click="displaySurahDetails({{ $surah->_id }})" class="mr-1 text-black cursor-pointer"><svg
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                    clip-rule="evenodd" />
            </svg>
        </span>
        <p class="text-black">
            {{ __('recitation.surah_info') }}
        </p>
    </div>
</div>
