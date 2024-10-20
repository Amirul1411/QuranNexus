<div x-data="{ open: false }" x-init="() => {
    Livewire.on('settingsSaved', () => {
        setTimeout(() => {
            window.location.reload(); // Refresh the page after 3 seconds
        }, 3000);
    });
}" @open-settings.window="open = $event.detail" x-cloak>

    {{-- Overlay to close the menu when clicked outside --}}
    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 z-40" @click="open = false"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    </div>

    {{-- Slide-in Settings Menu --}}
    <div x-show="open" class="fixed right-0 top-0 w-80 h-full bg-white shadow-lg z-50 p-5"
        x-transition:enter="transition transform ease-out duration-300" x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition transform ease-in duration-300"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">

        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold">{{ __('Settings') }}</h2>
            {{-- Close button --}}
            <button @click="open = false" class="text-black">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <x-section-border darkBorder="dark:border-gray-200" />

        {{-- Menu content goes here --}}
        <x-form-section submit="saveSettings" formDarkBg="dark:bg-white" buttonJustify="justify-center"
            darkBg="dark:bg-white" shadow="" grid="" class="">

            <div class="bg-white">
                <x-slot name="form">

                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col gap-2">
                            {{-- Tafseer --}}
                            <x-label darkTextColor="dark:text-gray-700" value="{{ __('Tafseer') }}" class="w-[15rem]" />
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <x-button type="button" borderColor="border-black-500"
                                        class="text-black cursor-pointer w-[15rem] flex h-auto">
                                        <div class="w-5/6">
                                            {{ $this->selectedTafseerNameAndLanguage ?? __('Choose Tafseer') }}
                                        </div>
                                        <div class="w-1/6">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </div>
                                    </x-button>
                                </x-slot>

                                <x-slot name="content">
                                    <!-- Dropdown content -->
                                    @foreach ($tafseers as $tafseer)
                                        <x-dropdown-link href=""
                                            wire:click.prevent="$set('selectedTafseer', {{ $tafseer->id }})">
                                            {{ $tafseer->name }} - {{ $tafseer->language_name }}
                                        </x-dropdown-link>
                                    @endforeach
                                </x-slot>
                            </x-dropdown>
                        </div>
                        <div class="flex flex-col gap-2">
                            {{-- Translation --}}
                            <x-label darkTextColor="dark:text-gray-700" value="{{ __('Translation') }}"
                                class="w-[15rem]" />
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <x-button type="button" borderColor="border-black-500"
                                        class="text-black cursor-pointer w-[15rem] flex h-auto">
                                        <div class="w-5/6">
                                            {{ $this->selectedTranslationNameAndLanguage ?? __('Choose Translation') }}

                                        </div>
                                        <div class="w-1/6">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </div>
                                    </x-button>
                                </x-slot>

                                <x-slot name="content">
                                    <!-- Dropdown content -->
                                    @foreach ($translations as $translation)
                                        <x-dropdown-link href=""
                                            wire:click.prevent="$set('selectedTranslation', {{ $translation->id }})">
                                            {{ $translation->translator }} - {{ $translation->language }}
                                        </x-dropdown-link>
                                    @endforeach
                                </x-slot>
                            </x-dropdown>
                        </div>
                        <div class="flex flex-col gap-2">
                            {{-- Audio Recitation --}}
                            <x-label darkTextColor="dark:text-gray-700" value="{{ __('Audio Recitation') }}"
                                class="w-[15rem]" />
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <x-button type="button" borderColor="border-black-500"
                                        class="text-black cursor-pointer w-[15rem] flex h-auto">
                                        <div class="w-5/6">
                                            {{ $this->selectedAudioRecitationName ?? __('Choose Audio Recitation') }}
                                        </div>
                                        <div class="w-1/6">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </div>
                                    </x-button>
                                </x-slot>

                                <x-slot name="content">
                                    <!-- Dropdown content -->
                                    @foreach ($audioRecitations as $audio)
                                        <x-dropdown-link href=""
                                            wire:click.prevent="$set('selectedAudio', {{ $audio->id }})">
                                            {{ $audio->reciter_name }}
                                        </x-dropdown-link>
                                    @endforeach
                                </x-slot>
                            </x-dropdown>
                        </div>
                        <div class="flex flex-col gap-2">
                            {{-- Recitation Goal --}}
                            <x-label darkTextColor="dark:text-gray-700" value="{{ __('Recitation Goal (Minutes)') }}"
                                class="w-[15rem]" />
                            <div class="relative w-[15rem]">
                                <x-input type="text" darkBorder="border-black-500" wire:model="recitationGoal"
                                    darkBg="dark:bg-gray-200" darkText="dark:text-black" class="w-full h-auto pr-10">
                                    {{ $this->recitationGoal}}
                                </x-input>
                            </div>
                        </div>
                        @if (session('not logged in'))
                            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                                class="text-red-500 font-base w-[15rem] text-center">
                                {{ session('not logged in') }}
                            </div>
                        @endif

                        @if (session('all null'))
                            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                                class="text-red-500 font-base w-[15rem] text-center">
                                {{ session('all null') }}
                            </div>
                        @endif

                        @if (session('successful'))
                            <div x-data="{ show: true, open: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                                class="text-green-500 font-base w-[15rem] text-center">
                                {{ session('successful') }}
                            </div>
                            <div x-data x-init="setTimeout(() => open = false, 3000)"></div>
                        @endif

                        <!-- Display error message for recitationGoal -->
                        @error('recitationGoal')
                            <div class="text-red-500 font-base w-[15rem] text-center">{{ $message }}</div>
                        @enderror
                    </div>
                </x-slot>
            </div>


            <x-slot name="actions">
                <x-button
                    class="bg-gradient-to-r from-light-green via-light-green-teal via-56 to-teal font-serif font-medium">
                    {{ __('Save Settings') }}
                </x-button>
            </x-slot>
        </x-form-section>
    </div>
</div>
