@props(['disabled' => false, 'border' => 'border-gray-300', 'darkBorder' => 'dark:border-gray-700', 'darkText' => 'dark:text-gray-300', 'darkBg' => 'dark:bg-gray-900', 'rounded' => 'rounded-md'])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => ' ' . $border . ' ' . $darkBorder . ' ' . $darkBg . ' ' . $darkText . ' focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 '.$rounded.' shadow-sm']) !!}>
