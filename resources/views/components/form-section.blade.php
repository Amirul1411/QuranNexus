@props([
    'submit',
    'darkBg' => 'dark:bg-gray-800',
    'buttonJustify' => 'justify-end',
    'shadow' => 'shadow',
    'grid' => 'md:grid md:grid-cols-3 md:gap-6'
])

<div {{ $attributes->merge(['class' =>  $grid ]) }}>
    @if (isset($title) && isset($description))
        <x-section-title>
            <x-slot name="title">{{ $title }}</x-slot>
            <x-slot name="description">{{ $description }}</x-slot>
        </x-section-title>
    @endif

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit="{{ $submit }}">
            <div
                class=" {{ $darkBg }} {{ $shadow }} px-4 py-5 bg-white sm:p-6 {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div
                    class="{{ $buttonJustify }} {{ $darkBg }} {{ $shadow }} flex items-center px-4 py-3 bg-gray-50 text-end sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
