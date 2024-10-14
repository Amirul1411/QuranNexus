@props(['value', 'darkTextColor' => 'dark:text-gray-300'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700'.$darkTextColor]) }}>
    {{ $value ?? $slot }}
</label>
