<x-app-layout title="FAQs" backgroundImage="background-image">
    <x-slot name="header" class="">
        <div class="flex flex-col mt-40 gap-8 ms-36">
            <p class="text-5xl font-serif font-bold w-1/2">{{ __('faqs.header_title') }}</p>
            <p class="text-base font-serif font-semibold  w-1/2">{{ __('faqs.header_subtitle_1') }}</p>
            <p class="text-base font-serif font-semibold  w-1/2 text-gray-500">{{ __('faqs.header_subtitle_2') }}</p>
        </div>
    </x-slot>

    <div class="flex flex-col items-end justify-end w-full me-36 my-40" x-data="{ open: null }">
        <!-- Accordion Item 1 -->
        <div class="mb-2 border rounded-lg w-3/5">
            <button @click="open === 1 ? open = null : open = 1" class="w-full px-4 py-2 text-left text-lg font-semibold text-gray-900 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Accordion Item 1
                <span x-show="open === 1" class="float-right">▼</span>
                <span x-show="open !== 1" class="float-right">▶</span>
            </button>
            <div x-show="open === 1" x-transition class="px-4 py-2 bg-white border-t border-gray-200">
                <p>This is the content for accordion item 1.</p>
            </div>
        </div>

        <!-- Accordion Item 2 -->
        <div class="mb-2 border rounded-lg w-3/5">
            <button @click="open === 2 ? open = null : open = 2" class="w-full px-4 py-2 text-left text-lg font-semibold text-gray-900 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Accordion Item 2
                <span x-show="open === 2" class="float-right">▼</span>
                <span x-show="open !== 2" class="float-right">▶</span>
            </button>
            <div x-show="open === 2" x-transition class="px-4 py-2 bg-white border-t border-gray-200">
                <p>This is the content for accordion item 2.</p>
            </div>
        </div>

        <!-- Accordion Item 3 -->
        <div class="mb-2 border rounded-lg w-3/5">
            <button @click="open === 3 ? open = null : open = 3" class="w-full px-4 py-2 text-left text-lg font-semibold text-gray-900 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Accordion Item 3
                <span x-show="open === 3" class="float-right">▼</span>
                <span x-show="open !== 3" class="float-right">▶</span>
            </button>
            <div x-show="open === 3" x-transition class="px-4 py-2 bg-white border-t border-gray-200">
                <p>This is the content for accordion item 3.</p>
            </div>
        </div>

        <!-- Accordion Item 4 -->
        <div class="mb-2 border rounded-lg w-3/5">
            <button @click="open === 4 ? open = null : open = 4" class="w-full px-4 py-2 text-left text-lg font-semibold text-gray-900 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Accordion Item 4
                <span x-show="open === 4" class="float-right">▼</span>
                <span x-show="open !== 4" class="float-right">▶</span>
            </button>
            <div x-show="open === 4" x-transition class="px-4 py-2 bg-white border-t border-gray-200">
                <p>This is the content for accordion item 4.</p>
            </div>
        </div>

        <!-- Accordion Item 5 -->
        <div class="mb-2 border rounded-lg w-3/5">
            <button @click="open === 5 ? open = null : open = 5" class="w-full px-4 py-2 text-left text-lg font-semibold text-gray-900 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Accordion Item 5
                <span x-show="open === 5" class="float-right">▼</span>
                <span x-show="open !== 5" class="float-right">▶</span>
            </button>
            <div x-show="open === 5" x-transition class="px-4 py-2 bg-white border-t border-gray-200">
                <p>This is the content for accordion item 5.</p>
            </div>
        </div>

        <!-- Accordion Item 6 -->
        <div class="mb-2 border rounded-lg w-3/5">
            <button @click="open === 6 ? open = null : open = 6" class="w-full px-4 py-2 text-left text-lg font-semibold text-gray-900 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Accordion Item 6
                <span x-show="open === 6" class="float-right">▼</span>
                <span x-show="open !== 6" class="float-right">▶</span>
            </button>
            <div x-show="open === 6" x-transition class="px-4 py-2 bg-white border-t border-gray-200">
                <p>This is the content for accordion item 6.</p>
            </div>
        </div>

        <!-- Accordion Item 7 -->
        <div class="mb-2 border rounded-lg w-3/5">
            <button @click="open === 7 ? open = null : open = 7" class="w-full px-4 py-2 text-left text-lg font-semibold text-gray-900 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Accordion Item 7
                <span x-show="open === 7" class="float-right">▼</span>
                <span x-show="open !== 7" class="float-right">▶</span>
            </button>
            <div x-show="open === 7" x-transition class="px-4 py-2 bg-white border-t border-gray-200">
                <p>This is the content for accordion item 7.</p>
            </div>
        </div>
    </div>

</x-app-layout>
