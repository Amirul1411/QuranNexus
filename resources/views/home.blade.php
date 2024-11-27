<x-app-layout title="Home Page">
    <x-slot name="header">
        <div class="header-image bg-cover">
            <div class="container mx-auto pt-5">
                <div class="flex flex-col absolute left-96 top-80">
                    <h1 class="text-left text-white text-5xl w-96 font-serif">{{ __('home.header_title') }}</h1>
                    <div class="flex justify-end my-7">
                        <p class="text-sm text-white  w-80 text-justify font-serif">{{ __('home.header_subtitle') }}
                        </p>
                    </div>
                    <div class="flex justify-end">
                        <a class="font-serif text-black bg-white rounded-lg font-bold mt-3 relative w-52 py-1 text-center"
                            href="{{ route('surah.index') }}">{{ __('home.header_button') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="my-12">
        <div class="flex flex-col mt-12">
            <h1 class="text-center font-bold mx-auto my-3 w-1/2 font-serif text-3xl">{{ __('home.body_title') }}</h1>
            <p class="text-center text-gray-600 mx-auto my-3 w-1/2 font-serif">{{ __('home.body_subtitle') }}</p>
        </div>

        <div class="flex flex-wrap w-3/4 mx-auto my-24 homecard pb-10">
            <div class="w-full md:w-3/5 flex flex-col justify-between py-3">
                <h4 class="font-bold my-2 text-3xl font-serif text-center">{{ __('home.card1_title') }}</h4>
                <p class="font-bold my-2 flex items-center font-serif">
                    <img class="nexus-logo-card text-black mr-2 w-6"
                        src="{{ Storage::url('web-images/nexus-logo-card-image.png') }}"
                        alt="Quran Nexus Logo Image">
                    {{ __('home.card1_point1') }}
                </p>
                <p class="pl-8 font-serif text-gray-600">
                    {{ __('home.card1_subpoint1') }}
                </p>
                <p class="font-bold my-2 flex items-center font-serif">
                    <img class="nexus-logo-card text-black mr-2 w-6"
                        src="{{ Storage::url('web-images/nexus-logo-card-image.png') }}"
                        alt="Quran Nexus Logo Image">
                    {{ __('home.card1_point2') }}
                </p>
                <p class="pl-8 font-serif text-gray-600">
                    {{ __('home.card1_subpoint2') }}
                </p>
                <button class="btn ml-8 border border-gray-300 w-40 py-1">{{ __('home.card1_button') }}</button>
            </div>
            <div class="w-full md:w-2/5">
                <img src="{{ Storage::url('web-images/AI-image.png') }}" alt="AI Image">
            </div>
        </div>

        <div class="flex flex-wrap w-3/4 mx-auto mb-16 home-recitation">
            <div class="w-full md:w-2/5 flex p-0">
                <img src="{{ Storage::url('web-images/home-quran-image.png') }}" alt="Quran Image">
            </div>
            <div class="w-full md:w-3/5 flex flex-col justify-between homecard">
                <h4 class="font-bold text-center my-3 text-3xl font-serif">{{ __('home.card2_title') }}</h4>
                <p class="font-bold my-2 flex items-center font-serif ml-16">
                    <img class="nexus-logo-card text-black mr-2 w-6"
                        src="{{ Storage::url('web-images/nexus-logo-card-image.png') }}"
                        alt="Quran Nexus Logo Image">
                    {{ __('home.card2_point1') }}
                </p>
                <p class="pl-24 pr-4 font-serif text-gray-600">
                    {{ __('home.card2_subpoint1') }} </p>
                <p class="font-bold my-2 flex items-center font-serif ml-16 pe-16">
                    <img class="nexus-logo-card text-black mr-2 w-6"
                        src="{{ Storage::url('web-images/nexus-logo-card-image.png') }}"
                        alt="Quran Nexus Logo Image">
                    {{ __('home.card2_point2') }}
                </p>
                <p class="pl-24 pr-4 font-serif text-gray-600">
                    {{ __('home.card2_subpoint2') }}
                </p>
                <div class="flex justify-end m-5">
                    <a class="btn w-40 ml-4 border border-black font-serif py-1 text-center"
                        href="{{ route('surah.index') }}">{{ __('home.card2_button') }}</a>
                </div>
            </div>
        </div>
        <div class="my-5 flex flex-col w-1/2 mx-auto home-ready">
            <h2 class="font-bold text-center text-3xl font-sans mb-8">{{ __('home.ready') }}</h2>
            <div class="flex justify-center mx-auto my-1 gap-2">
                <a class="btn-color rounded-full text-white px-5 py-1 font-sans" href="{{ route('register') }}">
                    {{ __('home.sign_up') }}
                </a>
                <a class="font-sans rounded-full px-5 py-1 border btn-color-outline hover:btn-color-outline-fill transition duration-300 ease-in-out"
                    href="{{ route('contact') }}">
                    {{ __('home.contact_us') }}
                </a>
            </div>
        </div>
    </div>

</x-app-layout>
