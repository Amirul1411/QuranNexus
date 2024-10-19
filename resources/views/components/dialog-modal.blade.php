@props(['id' => null, 'maxWidth' => null, 'darkBg' => 'dark:bg-gray-800', 'footerPosition' => 'text-end', 'footerJustify' => 'justify-end', 'footerItems', 'footerPaddingY' => 'py-4'])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }} darkBg="{{ $darkBg }}">
    <div class="px-6 py-4">
        <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ $title }}
        </div>

        <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row  {{ $footerItems }} {{ $footerJustify }} px-6 {{ $footerPaddingY }} bg-gray-100 {{ $darkBg }} {{ $footerPosition }}">
        {{ $footer }}
    </div>
</x-modal>
