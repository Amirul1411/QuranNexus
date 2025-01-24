<x-app-layout title="Search Results">
    <div class="w-full h-screen" style="background: linear-gradient(90deg, #86D6C3 0%, #75FF9C 100%); padding-top: 80px;">
        <div class="max-w-4xl mx-auto">
            <!-- Back Button -->
            <a href="{{ route('basic-search') }}" class="text-blue-600 hover:underline mt-4 block">
                &larr; Back to Search
            </a>

            <!-- Search Results Section -->
            <div class="bg-white shadow-lg rounded-lg p-6 mt-4">
                <h1 class="text-2xl font-bold text-[#2D6360] mb-4">Search Results</h1>
                <p class="mb-4 text-gray-500">Results for: <strong>{{ $searchTerm }}</strong></p>

                @if ($results->isEmpty())
                    <p class="text-gray-500">No results found.</p>
                @else
                    <ul class="space-y-4">
                        @foreach ($results as $result)
                            <li class="border border-gray-300 p-4 rounded">
                                @if ($searchIn === 'Words')
                                    <!-- Display Word Details -->
                                    <p><strong>Surah ID:</strong> {{ $result->surah_id }}</p>
                                    <p><strong>Ayah Index:</strong> {{ $result->ayah_index }}</p>
                                    <p><strong>Word Index:</strong> {{ $result->word_index }}</p>
                                    <p><strong>Text:</strong> {{ $result->text }}</p>
                                    <p><strong>Transliteration:</strong> {{ $result->transliteration }}</p>
                                    <p><strong>Translation:</strong> {{ $result->translation }}</p>
                                @elseif ($searchIn === 'Ayahs')
                                    <!-- Highlight Matching Words in Ayah Text -->
                                    <p><strong>Surah ID:</strong> {{ $result->surah_id }}</p>
                                    <p><strong>Ayah Index:</strong> {{ $result->ayah_index }}</p>
                                    <p><strong>Text:</strong>
                                        @php
                                            $highlightedText = preg_replace(
                                                "/(" . preg_quote($searchTerm, '/') . ")/iu",
                                                '<span class="bg-yellow-300">$1</span>',
                                                $result->text
                                            );
                                        @endphp
                                        {!! $highlightedText !!}
                                    </p>
                                @else
                                    <!-- Default Display for Other Collections -->
                                    <p><strong>Surah ID:</strong> {{ $result->surah_id }}</p>
                                    <p><strong>Ayah Index:</strong> {{ $result->ayah_index }}</p>
                                    <p><strong>Text:</strong> {{ $result->text }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
