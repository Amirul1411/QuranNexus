@props(['darkBg' => 'dark:bg-gray-900'])

<input type="checkbox" {!! $attributes->merge(['class' => 'rounded '.$darkBg.' border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800']) !!}>
