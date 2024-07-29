<x-app-layout title="Home Page">
    <x-slot name="header">
        <div class="header-image">
            <div class="container mx-auto pt-5">
                <div class="flex flex-col absolute left-96 top-80">
                    <h1 class="text-left text-white text-5xl w-96 font-serif">{{ __('home.header_title') }}</h1>
                    <div class="flex justify-end my-7">
                        <p class="text-sm text-white  w-80 text-justify font-serif">{{ __('home.header_subtitle') }}
                        </p>
                    </div>
                    <div class="flex justify-end">
                        <button class="font-serif text-black bg-white rounded-lg font-bold mt-3 relative w-52 py-1">{{ __('home.header_button') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="my-12">
        <div class="flex flex-col mt-12">
            <h1 class="text-center font-bold mx-auto my-3 w-1/2 font-serif text-3xl">Dive Into Quran Nexus: Your Complete
                Quranic Toolkit</h1>
            <p class="text-center text-gray-600 mx-auto my-3 w-1/2 font-serif">Discover a comprehensive suite of tools and
                resources designed to enrich your Quranic experience. With Quran Nexus, delve deeper into the divine wisdom
                of the Quran like never before.</p>
        </div>

        <div class="flex flex-wrap w-3/4 mx-auto my-24 homecard pb-10">
            <div class="w-full md:w-3/5 flex flex-col justify-between py-3">
                <h4 class="font-bold my-2 text-3xl font-serif text-center">DEVELOPER'S RESOURCES</h4>
                <p class="font-bold my-2 flex items-center font-serif">
                    <img class="nexus-logo-card text-black mr-2 w-6"
                        src="{{ Vite::asset('resources/images/nexus-logo-card-image.png') }}" alt="Quran Nexus Logo Image">
                    Comprehensive API
                </p>
                <p class="pl-8 font-serif text-gray-600">
                    Access our robust API to integrate Quran recitation features into your applications.
                </p>
                <p class="font-bold my-2 flex items-center font-serif">
                    <img class="nexus-logo-card text-black mr-2 w-6"
                        src="{{ Vite::asset('resources/images/nexus-logo-card-image.png') }}" alt="Quran Nexus Logo Image">
                    Documentation
                </p>
                <p class="pl-8 font-serif text-gray-600">
                    Detailed documentation to help you get started quickly and efficiently.
                </p>
                <button class="btn ml-8 border w-40 py-1">TRY NOW</button>
            </div>
            <div class="w-full md:w-2/5">
                <img src="{{ Vite::asset('resources/images/AI-image.png') }}" alt="AI Image">
            </div>
        </div>

        <div class="flex flex-wrap w-3/4 mx-auto mb-16 home-recitation">
            <div class="w-full md:w-2/5 flex p-0">
                <img src="{{ Vite::asset('resources/images/home-quran-image.png') }}" alt="Quran Image">
            </div>
            <div class="w-full md:w-3/5 flex flex-col justify-between homecard">
                <h4 class="font-bold text-center my-3 text-3xl font-serif">QURAN RECITATION HUB</h4>
                <p class="font-bold my-2 flex items-center font-serif ml-16">
                    <img class="nexus-logo-card text-black mr-2 w-6"
                        src="{{ Vite::asset('resources/images/nexus-logo-card-image.png') }}" alt="Quran Nexus Logo Image">
                    Complete Quranic Text
                </p>
                <p class="pl-24 pr-4 font-serif text-gray-600">
                    Authentic Quranic text awaits, presenting every Surah and Ayah for your spiritual exploration.
                </p>
                <p class="font-bold my-2 flex items-center font-serif ml-16 pe-16">
                    <img class="nexus-logo-card text-black mr-2 w-6"
                        src="{{ Vite::asset('resources/images/nexus-logo-card-image.png') }}" alt="Quran Nexus Logo Image">
                    Immersive Audio and Translation
                </p>
                <p class="pl-24 pr-4 font-serif text-gray-600">
                    Immerse yourself in the sublime verses of the Quran with our immersive audio recitations and nuanced
                    translations.
                </p>
                <div class="flex justify-end m-5">
                    <button class="btn w-40 ml-4 border border-black font-serif py-1">RECITE NOW</button>
                </div>
            </div>
        </div>
        <div class="my-5 flex flex-col w-1/2 mx-auto home-ready">
            <h2 class="font-bold text-center text-3xl font-sans mb-8">Ready to get started?</h2>
            <div class="flex justify-center mx-auto my-1 gap-2">
                <button class="btn-color rounded-full text-white px-5 py-1 font-sans">
                    Sign Up, It's Free
                </button>
                <button class="font-sans rounded-full px-5 py-1 border btn-color-outline hover:btn-color-outline-fill transition duration-300 ease-in-out">
                    Contact Us
                </button>
            </div>
        </div>
    </div>

</x-app-layout>
