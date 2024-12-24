<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayah Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center h-screen bg-white">
    <div class="bg-[#2D6360] rounded-lg p-6 shadow-lg w-3/4">
        @if ($ayah)
            <!-- Dynamic Label -->
            <h1 class="text-center text-2xl font-bold text-white mb-4">
                Surah {{ $surahName }} : Ayah {{ explode(':', $ayah->ayah_key)[1] }}
            </h1>

            <!-- Form for Editing and Verifying Ayah -->
            <form action="{{ route('ayah.verify', ['ayahKey' => $ayah->ayah_key]) }}" method="POST">
                @csrf
                <!-- Editable Text Box -->
                <textarea
                    name="text"
                    class="w-full p-2 rounded text-black"
                    rows="4"
                >{{ $ayah->text }}</textarea>

                <div class="flex justify-center items-center space-x-4 mt-4">
                    
                    <!-- Next Button -->
                    <a href="{{ route('ayah.next', ['ayahKey' => $ayah->ayah_key]) }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Next
                    </a>
                    <!-- Verify Button -->
                    <button class="bg-green-500 text-white px-4 py-2 rounded" type="submit">
                        Verify
                    </button>

                    
                    <!-- Back Button -->
                    <a href="{{ route('ayah.back', ['ayahKey' => $ayah->ayah_key]) }}" class="bg-gray-500 text-white px-4 py-2 rounded">
                        Back
                    </a>
                </div>
            </form>
        @else
            <!-- No Ayah Found -->
            <div class="text-center text-red-500 font-bold">
                The selected ayah does not exist.
            </div>
        @endif
    </div>
</body>
</html>
