<x-app-layout title="Tafseer">
    <x-slot name="header">
        <div class="flex flex-col items-center mt-40 gap-16 text-white pb-16 border-b-2 border-white">
            <p class="text-5xl font-serif font-semibold">Surah {{ $ayah->surah->tname }}</p>
            <div class="flex justify-between w-1/3">
                <div class="flex flex-col">
                    <p class="text-3xl font-serif text-center font-medium">Ayah</p>
                    <p class="text-2xl font-serif text-center font-medium text-gray-400">{{ $ayah->ayah_index }}</p>
                </div>
                <div class="flex flex-col">
                    <p class="text-3xl font-serif text-center font-medium">Revelation Place</p>
                    <p class="text-2xl font-serif text-center font-medium text-gray-400">{{ $ayah->surah->type }}</p>
                </div>
            </div>
        </div>
    </x-slot>
    @if ($htmlContent != '')
        <div class="text-white my-16 mx-40 text-justify font-sans">{!! $htmlContent !!}</div>
    @else
        <div class="text-white my-16 mx-40 text-justify font-sans">Tafseer for this ayah is not found.</div>
    @endif
</x-app-layout>
