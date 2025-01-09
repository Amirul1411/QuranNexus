<x-app-layout title="FAQs" backgroundImage="background-image">
    <x-slot name="header" class="">
        <div class="flex flex-col mt-40 gap-4 ms-36">
            <p class="text-5xl font-serif font-bold w-1/2 mb-8">{{ __('faqs.header_title') }}</p>
            <p class="text-base font-serif font-semibold  w-1/2">{{ __('faqs.header_subtitle_1') }}</p>
            <p class="text-base font-serif font-semibold  w-1/2 text-gray-500">{{ __('faqs.header_subtitle_2') }}<a
                    class="text-base font-serif font-semibold  w-1/2 text-gray-500"
                    href="{{ route('contact') }}">inquiry</a></p>
        </div>
    </x-slot>

    <div class="flex flex-col items-end justify-end w-full me-36 my-40" x-data="{ open: null }">
        <div class="border border-gray-400 w-3/5 bg-transparent rounded-lg">
            <!-- Accordion Item 1 -->
            <div class="border-b border-gray-400">
                <button @click="open === 1 ? open = null : open = 1"
                    class="rounded-t-lg w-full px-6 py-6 text-left text-lg font-semibold font-serif text-gray-900 bg-transparent hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    {{ __('faqs.item_1_title') }}
                    <span :class="{ 'rotate-90': open === 1, 'rotate-0': open !== 1 }" x-transition
                        class="float-right transition-transform duration-300">▶</span>
                </button>
                <div x-show="open === 1" x-transition class="px-6 py-6 bg-transparent">
                    <p class="font-serif text-gray-600 font-semibold">{{ __('faqs.item_1_subtitle') }}</p>
                </div>
            </div>

            <!-- Accordion Item 2 -->
            <div class="border-b border-gray-400">
                <button @click="open === 2 ? open = null : open = 2"
                    class="w-full px-6 py-6 text-left text-lg font-semibold font-serif text-gray-900 bg-transparent hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    {{ __('faqs.item_2_title') }}
                    <span :class="{ 'rotate-90': open === 2, 'rotate-0': open !== 2 }" x-transition
                        class="float-right transition-transform duration-300">▶</span>
                </button>
                <div x-show="open === 2" x-transition class="px-6 py-6 bg-transparent">
                    <p class="font-serif text-gray-600 font-semibold">{{ __('faqs.item_2_subtitle') }}</p>
                </div>
            </div>

            <!-- Accordion Item 3 -->
            <div class="border-b border-gray-400">
                <button @click="open === 3 ? open = null : open = 3"
                    class="w-full px-6 py-6 text-left text-lg font-semibold font-serif text-gray-900 bg-transparent hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    {{ __('faqs.item_3_title') }}
                    <span :class="{ 'rotate-90': open === 3, 'rotate-0': open !== 3 }" x-transition
                        class="float-right transition-transform duration-300">▶</span>
                </button>
                <div x-show="open === 3" x-transition class="px-6 py-6 bg-transparent">
                    <p class="font-serif text-gray-600 font-semibold">{{ __('faqs.item_3_subtitle') }}</p>
                </div>
            </div>

            <!-- Accordion Item 4 -->
            <div class="border-b border-gray-400">
                <button @click="open === 4 ? open = null : open = 4"
                    class="w-full px-6 py-6 text-left text-lg font-semibold font-serif text-gray-900 bg-transparent hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    {{ __('faqs.item_4_title') }}
                    <span :class="{ 'rotate-90': open === 4, 'rotate-0': open !== 4 }" x-transition
                        class="float-right transition-transform duration-300">▶</span>
                </button>
                <div x-show="open === 4" x-transition class="px-6 py-6 bg-transparent">
                    <p class="font-serif text-gray-600 font-semibold">{{ __('faqs.item_4_subtitle') }}</p>
                </div>
            </div>

            <!-- Accordion Item 5 -->
            <div class="border-b border-gray-400">
                <button @click="open === 5 ? open = null : open = 5"
                    class="w-full px-6 py-6 text-left text-lg font-semibold font-serif text-gray-900 bg-transparent hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    {{ __('faqs.item_5_title') }}
                    <span :class="{ 'rotate-90': open === 5, 'rotate-0': open !== 5 }" x-transition
                        class="float-right transition-transform duration-300">▶</span>
                </button>
                <div x-show="open === 5" x-transition class="px-6 py-6 bg-transparent">
                    <p class="font-serif text-gray-600 font-semibold">{{ __('faqs.item_5_subtitle') }}</p>
                </div>
            </div>

            <!-- Accordion Item 6 -->
            <div class="border-b border-gray-400">
                <button @click="open === 6 ? open = null : open = 6"
                    class="w-full px-6 py-6 text-left text-lg font-semibold font-serif text-gray-900 bg-transparent hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    {{ __('faqs.item_6_title') }}
                    <span :class="{ 'rotate-90': open === 6, 'rotate-0': open !== 6 }" x-transition
                        class="float-right transition-transform duration-300">▶</span>
                </button>
                <div x-show="open === 6" x-transition class="px-6 py-6 bg-transparent">
                    <p class="font-serif text-gray-600 font-semibold">{{ __('faqs.item_6_subtitle') }}</p>
                </div>
            </div>

            <!-- Accordion Item 7 -->
            <div>
                <button @click="open === 7 ? open = null : open = 7"
                    class="w-full px-6 py-6 text-left text-lg font-semibold font-serif text-gray-900 bg-transparent hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    {{ __('faqs.item_7_title') }}
                    <span :class="{ 'rotate-90': open === 7, 'rotate-0': open !== 7 }" x-transition
                        class="float-right transition-transform duration-300">▶</span>
                </button>
                <div x-show="open === 7" x-transition class="px-6 py-6 bg-transparent">
                    <p class="font-serif text-gray-600 font-semibold">{{ __('faqs.item_7_subtitle') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
