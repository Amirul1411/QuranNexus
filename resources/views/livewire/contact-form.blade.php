<x-form-section submit="submitForm" formStyle="dark:bg-white" titleHidden="true" buttonStyle="dark:bg-white" buttonJustifyEnd="false">

    <x-slot name="title">
        {{-- <p class="text-xl text-gray-600 font-serif">
            Contact Us
        </p> --}}
    </x-slot>

    <x-slot name="description">
        {{-- <p class="text-3xl text-gray-600 font-serif">
            Please fill out the form below to get in touch with us.
        </p> --}}
    </x-slot>

    <div class="bg-white">
        <x-slot name="form">

            <div class="col-span-3 sm:col-span-4">
                <p class="text-3xl text-gray-500 font-serif">Contact Us</p>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <div class="grid grid-cols-6 gap-4">
                    <div class="col-span-3">
                        <x-input id="firstName" type="text" class="dark:bg-white mt-1 block w-full font-serif" wire:model="firstName" placeholder="First Name"/>
                        <x-input-error for="firstName" class="mt-2" />
                    </div>
                    <div class="col-span-3">
                        <x-input id="lastName" type="text" class="dark:bg-white mt-1 block w-full font-serif" wire:model="lastName" placeholder="Last Name"/>
                        <x-input-error for="lastName" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="col-span-3 sm:col-span-4">
                <x-input id="phone" type="text" class="dark:bg-white mt-1 block w-full font-serif" wire:model="phone" placeholder="Phone"/>
                <x-input-error for="phone" class="mt-2" />
            </div>

            <div class="col-span-3 sm:col-span-4">
                <x-input id="email" type="email" class="dark:bg-white mt-1 block w-full font-serif" wire:model="email" placeholder="Email"/>
                <x-input-error for="email" class="mt-2" />
            </div>

            <div class="col-span-3 sm:col-span-4">
                <textarea type='textarea' id="message" class="dark:bg-white mt-1 block w-full font-serif" wire:model="message" placeholder="Message"></textarea>
                <x-input-error for="message" class="mt-2" />
            </div>
        </x-slot>
    </div>


    <x-slot name="actions">
        <x-button>
            Send Message
        </x-button>
    </x-slot>
</x-form-section>
