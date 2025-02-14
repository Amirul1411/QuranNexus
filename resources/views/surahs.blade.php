<x-app-layout title="All Surah">
    <x-slot name="header">
        <h1>List of Surahs</h1>
    </x-slot>
    <ul>
        @foreach ($surahs as $surah)
            <li>
                <strong>{{ $surah->name }}</strong> ({{ $surah->tname }} - {{ $surah->ename }})
                <p>Type: {{ $surah->type }} | Ayahs: {{ $surah->ayas }}</p>
            </li>
            <hr>
        @endforeach
    </ul>
</x-app-layout title="All Surah">
