<x-app-layout title="Contact Us">
    <x-slot name="header">
        <div class="flex flex-col justify-center items-center mt-32 gap-8">
            <p class="text-5xl font-serif font-bold">{{ __('contact.header_title') }}</p>
            <p class="text-base font-serif text-center font-medium  w-1/2">{{ __('contact.header_subtitle') }}</p>
        </div>
    </x-slot>
    <div class="flex justify-center items-center my-48">
        <div class="w-2/3">
            @livewire('contact-form')
        </div>
        <div class="w-1/3 flex flex-col justify-center items-center">
            <p class="text-2xl font-serif font-bold">{{ __('contact.body_title') }}</p>
            <p class="text-base font-serif text-center font-medium">{{ __('contact.body_subtitle') }}</p>
        </div>
    </div>
</x-app-layout>
