<x-app-layout title="Translation Verification">
    <div class="flex justify-center items-center h-screen w-full" style="background: linear-gradient(90deg, #86D6C3 0%, #75FF9C 100%);">
        <div class="bg-[#BCFFCE] rounded-lg p-8 shadow-lg w-3/4 max-w-4xl">
            <!-- Page Title -->
            <h1 class="text-center text-3xl font-bold text-[#2D6360] mb-6">
                Translation Verification
            </h1>

            @if ($ayah && $translation)
                <!-- Surah and Ayah Selection -->
                <form id="navigation-form" action="{{ route('translation.index') }}" method="GET" class="mb-6">
                    <div class="flex justify-center space-x-4 items-center">
                        <!-- Surah Dropdown -->
                        <select name="surah_id"
                            class="p-2 rounded border border-gray-300 focus:ring focus:ring-[#4CAF50] appearance-none bg-white pr-8">
                            @foreach ($surahs as $surah)
                                <option value="{{ $surah->_id }}" {{ $surah->_id == $surahId ? 'selected' : '' }}>
                                    {{ $surah->tname }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Ayah Dropdown -->
                        <select name="ayah_index"
                            class="p-2 rounded border border-gray-300 focus:ring focus:ring-[#4CAF50] appearance-none bg-white pr-8">
                            @for ($i = 1; $i <= $totalAyahs; $i++)
                                <option value="{{ $i }}" {{ $i == $ayahIndex ? 'selected' : '' }}>
                                    Ayah {{ $i }}
                                </option>
                            @endfor
                        </select>

                        <!-- Go Button -->
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                            Go
                        </button>
                    </div>
                </form>

                <!-- Ayah Text Display -->
                <div class="bg-white rounded-lg p-4 shadow-inner mb-6">
                    <p class="text-right text-2xl font-serif font-semibold text-[#2D6360]">
                        {{ $ayah->text }}
                    </p>
                </div>

                <!-- Form for Editing and Verifying Translation -->
                <form action="{{ route('translation.verify', ['ayahKey' => $translation->ayah_key]) }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Editable Translation Input -->
                    <div>
                        <textarea
                            name="text"
                            class="w-full p-3 border border-gray-300 rounded text-black focus:ring focus:ring-[#4CAF50]"
                            rows="4"
                        >{{ $translation->text }}</textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center">
                        <!-- Next Button -->
                        <a href="{{ route('translation.next', ['ayahKey' => $translation->ayah_key]) }}" class="bg-blue-500 text-white px-6 py-2 rounded shadow hover:bg-blue-600">
                            Next
                        </a>
                        <!-- Verify Button -->
                        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded shadow hover:bg-green-600">
                            Verify
                        </button>
                        <!-- Back Button -->
                        <a href="{{ route('translation.back', ['ayahKey' => $translation->ayah_key]) }}" class="bg-gray-500 text-white px-6 py-2 rounded shadow hover:bg-gray-600">
                            Back
                        </a>
                    </div>
                </form>
            @else
                <div class="text-center text-red-500 font-bold">
                    The selected Ayah or Translation does not exist.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Automatically submit the form when any dropdown changes
        $('select[name="surah_id"], select[name="ayah_index"]').change(function() {
            $('#navigation-form').submit();
        });
    });
</script>
