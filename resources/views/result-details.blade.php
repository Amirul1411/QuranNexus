<x-app-layout title="Result Details">
    <div class="w-full min-h-screen" style="background: linear-gradient(90deg, #86D6C3 0%, #75FF9C 100%); padding-top: 80px; padding-bottom: 80px;">
        <div class="max-w-4xl mx-auto">
            <!-- Back Button -->
            <a href="{{ route('basic-search') }}" class="text-blue-600 hover:underline mt-4 block">
                &larr; Back to Search
            </a>

            <!-- Detailed Information Section -->
            <div class="bg-white shadow-lg rounded-lg p-6 mt-4">
                <h1 class="text-2xl font-bold text-[#2D6360] mb-4">Result Details</h1>

                <div class="space-y-4">
                    <p><strong>Surah Name:</strong> {{ $surah_name ?? 'N/A' }}</p>
                    <p><strong>Surah ID:</strong> {{ $surah_id }}</p>
                    <p><strong>Ayah Index:</strong> {{ $ayah_index }}</p>
                    <p><strong>Juz Number:</strong> {{ $juz_id ?? 'N/A' }}</p>
                    <p><strong>Page Number:</strong> {{ $page_id ?? 'N/A' }}</p>

                    @if (isset($ayah_text))
                        <p><strong>Ayah Text:</strong> <span class="text-lg font-serif">{{ $ayah_text }}</span></p>
                    @endif

                    @if (isset($word_text))
                        <p><strong>Word:</strong> {{ $word_text }}</p>
                        <p><strong>Transliteration:</strong> {{ $word_transliteration }}</p>
                        <p><strong>Translation:</strong> {{ $word_translation }}</p>
                    @endif

                    @if (isset($audio_url))
                        <p><strong>Audio:</strong> 
                            <audio controls>
                                <source src="{{ asset($audio_url) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </p>
                    @endif

                    <p><strong>Verification Status:</strong> 
                        <span class="{{ $isVerified ? 'text-green-600' : 'text-red-600' }}">
                            {{ $isVerified ? 'Verified' : 'Not Verified' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
