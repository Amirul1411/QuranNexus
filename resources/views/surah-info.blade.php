<x-app-layout title="Surah Info">
    <x-slot name="header">
        <div class="flex flex-col items-center mt-40 gap-16 text-black pb-16 border-b-2 border-white">
            <p class="text-5xl font-serif font-bold">Surah {{ $surah->tname }}</p>
            <div class="flex justify-between w-1/3">
                <div class="flex flex-col">
                    <p class="text-3xl font-serif text-center font-semibold">Ayahs</p>
                    <p class="text-2xl font-serif text-center font-medium text-black">{{ $surah->ayas }}</p>
                </div>
                <div class="flex flex-col">
                    <p class="text-3xl font-serif text-center font-semibold">Revelation Place</p>
                    <p class="text-2xl font-serif text-center font-medium text-black">{{ $surah->type }}</p>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="text-black my-16 mx-40 text-justify font-sans">{!! $htmlContent !!}</div>
</x-app-layout>

