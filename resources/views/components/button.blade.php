@props([
    'borderWidth' => 'border',
    'borderColor' => 'border-transparent',
    'rounded' => 'rounded-md',
    'bg' => 'bg-gray-800',
    'darkBg' => 'dark:bg-gray-200',
    'text' => 'text-white',
    'darkText' => 'dark:text-gray-800',
    'uppercase' => 'uppercase',
    'tracking' => 'tracking-widest',
    'textSize' => 'text-sm',
    'activeBg' => 'active:bg-gray-900',
    'darkActiveBg' => 'dark:active:bg-gray-300',
    'hover' => 'hover:bg-gray-700',
    'darkHover' => 'dark:hover:bg-white',
    'focus' => 'focus:bg-gray-700',
    'darkFocus' => 'dark:focus:bg-white',
    'focusRingOffset' => 'focus:ring-offset-2',
    'darkFocusRingOffset' => 'dark:focus:ring-offset-gray-800',
    'fontWeight' => 'font-semibold'])

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 '.$bg.' '.$darkBg.' '.$borderWidth.' '.$borderColor.' '.$rounded.' '.$fontWeight.' '.$textSize.' '.$text.' '.$darkText.' '.$uppercase.' '.$tracking.' '.$hover.' '.$darkHover.' '.$focus.' '.$darkFocus.' '.$activeBg.' '.$darkActiveBg.' focus:outline-none focus:ring-2 focus:ring-indigo-500 '.$focusRingOffset.' '.$darkFocusRingOffset.' disabled:opacity-50 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
