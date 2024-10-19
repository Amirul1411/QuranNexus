@props(['borderColor' => 'border-transparent', 'rounded' => 'rounded-md', 'darkBg' => 'dark:bg-gray-200', 'darkText' => 'dark:text-gray-800', 'uppercase' => 'uppercase', 'tracking' => 'tracking-widest', 'textSize' => 'text-sm', 'darkActiveBg' => 'dark:active:bg-gray-300'])

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 '.$darkBg.' border '.$borderColor.' '.$rounded.' font-semibold '.$textSize.' text-white '.$darkText.' '.$uppercase.' '.$tracking.' hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 '.$darkActiveBg.' focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
