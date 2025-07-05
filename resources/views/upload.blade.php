<x-app-layout title="Upload Quranic Data">
    <div class="w-full h-screen" style="background: linear-gradient(90deg, #86D6C3 0%, #75FF9C 100%); padding-top: 80px;">
        <div class="bg-white shadow-lg rounded-lg p-6 max-w-4xl mx-auto">
            <!-- Page Title -->
            <h1 class="text-center text-3xl font-bold text-[#2D6360] mb-6">
                Upload Quranic Data
            </h1>

            <!-- Display Success or Error Messages -->
            @if (session('success'))
                <div class="bg-green-100 text-green-700 border border-green-500 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 border border-red-500 p-4 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Download Excel Template -->
            <div class="mb-6 text-center">
                <a href="{{ route('upload.downloadTemplate') }}" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700">
                    Download Excel Template
                </a>
            </div>

            <!-- Upload Form -->
            <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label class="block font-semibold mb-2">Upload File:</label>
                    <input type="file" name="excel_file" class="w-full border border-gray-300 p-3 rounded">
                </div>
                <div class="flex justify-center">
                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded shadow hover:bg-green-600">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
