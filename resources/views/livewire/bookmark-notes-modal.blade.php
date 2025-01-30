<x-dialog-modal id="bookmark-notes-modal" maxWidth="md" wire:model.live="show" darkBg="bg-white"
    footerPosition="text-center" footerJustify="justify-center" footerItems="items-start" footerPaddingY='pb-4'>

    <x-slot name="title">
        <h2 class="text-center text-3xl my-5 text-black font-bold">Add Notes</h2>
    </x-slot>

    <x-slot name="content">

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4" />

        <form wire:submit.prevent='saveBookmarks'>
            @csrf

            <div class="my-7 relative w-full justify-center flex">
                <x-label for="notes" value="notes" class="hidden" />
                <x-input border='border-black' wire:model.live="notes" rounded="rounded-full" darkBg="" darkText="dark:text-black" id="notes"
                    class="block mt-1 z-0 w-full font-semibold pl-12 border-2 text-black" type="text"
                    name="notes" required autofocus placeholder="Add your notes to this bookmark here..." />
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 z-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 text-black">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>

                </span>
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-button bg="bg-gradient-to-r from-light-green via-light-green-teal via-56 to-teal" text="text-black"
                    activeBg="" hover="" focus="" focusRingOffset="" borderWidth="border-0"
                    class="font-serif transform transition-transform duration-300 hover:scale-105">
                    Save
                </x-button>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
    </x-slot>
</x-dialog-modal>
