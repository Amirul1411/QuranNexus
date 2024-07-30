<x-form-section submit="submitForm" formDarkBg="dark:bg-white" buttonJustify="justify-start" darkBg="dark:bg-white" shadow="" grid="" class="border border-gray-300 w-2/3">

    <div class="bg-white">
        <x-slot name="form">

            <div class="col-span-3">
                <p class="text-3xl text-gray-500 font-serif">Contact Us</p>
            </div>

            <div class="col-span-6">
                <div class="grid grid-cols-6 gap-4">
                    <div class="col-span-3">
                        <x-input darkBorder="dark:border-gray-300" id="firstName" type="text" class="dark:bg-white mt-1 block w-full font-serif" wire:model="firstName" placeholder="First Name"/>
                        <x-input-error for="firstName" class="mt-2" />
                    </div>
                    <div class="col-span-3">
                        <x-input darkBorder="dark:border-gray-300" id="lastName" type="text" class="dark:bg-white mt-1 block w-full font-serif" wire:model="lastName" placeholder="Last Name"/>
                        <x-input-error for="lastName" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="col-span-6">
                <div class="grid grid-cols-6 gap-4">
                    <div class="col-span-3">
                        <x-input darkBorder="dark:border-gray-300" id="phone" type="text" class="dark:bg-white mt-1 block w-full font-serif" wire:model="phone" placeholder="Phone"/>
                        <x-input-error for="phone" class="mt-2" />
                    </div>
                    <div class="col-span-3">
                        <x-input darkBorder="dark:border-gray-300" id="email" type="email" class="dark:bg-white mt-1 block w-full font-serif" wire:model="email" placeholder="Email"/>
                        <x-input-error for="email" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="col-span-6">
                <textarea type='textarea' id="message" class="bg-white mt-1 block w-full font-serif h-40 border border-gray-300" wire:model="message" placeholder="Message"></textarea>
                <x-input-error for="message" class="mt-2" />
            </div>
        </x-slot>
    </div>


    <x-slot name="actions">
        <x-button class="bg-gradient-to-r from-light-green via-light-green-teal via-56 to-teal font-serif font-medium">
            Send Message
        </x-button>
    </x-slot>
</x-form-section>
