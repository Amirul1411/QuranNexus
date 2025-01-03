<x-app-layout title="Advanced Search Query Builder">
    <div class="bg-blue-50 p-8 w-full h-screen">
        <!-- Back to Basic Search -->
        <div class="mb-4">
            <a href="{{ route('basic-search') }}" class="text-blue-600 hover:underline text-sm font-semibold">
                &larr; Back to Basic Search
            </a>
        </div>

        <!-- Page Content -->
        <div class="bg-white shadow-lg rounded-lg p-6 max-w-4xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-4">
                <div class="flex space-x-6">
                    <button class="font-semibold text-blue-600 border-b-2 border-blue-600">DOCUMENTS</button>
                    <button class="text-gray-500 hover:text-blue-600">CITED REFERENCES</button>
                </div>
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    RECITERS
                </button>
            </div>

            <!-- Dropdowns -->
            <div class="mt-4">
                <label class="block font-semibold mb-1">Search in:</label>
                <select class="w-full border border-gray-300 p-2 rounded">
                    <option>Web of Science Core Collection</option>
                    <option>Other Collection</option>
                </select>
            </div>

            <div class="mt-4">
                <label class="block font-semibold mb-1">Editions:</label>
                <select class="w-full border border-gray-300 p-2 rounded">
                    <option>All</option>
                    <option>Edition 1</option>
                    <option>Edition 2</option>
                </select>
            </div>

            <!-- Query Builder -->
            <div class="mt-4">
                <div class="flex items-center space-x-4">
                    <select class="border border-gray-300 p-2 rounded">
                        <option>All Fields</option>
                        <option>Title</option>
                        <option>Author</option>
                    </select>
                    <input type="text" placeholder="Example: liver disease india singh"
                        class="flex-grow border border-gray-300 p-2 rounded" />
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add to query</button>
                </div>
            </div>

            <!-- Query Preview -->
            <div class="mt-4">
                <label class="block font-semibold mb-1">Query Preview:</label>
                <textarea class="w-full border border-gray-300 p-2 rounded" rows="3">
                gbgabgkabelg
            </textarea>
            </div>

            <!-- Options -->
            <div class="mt-4 flex justify-between items-center">
                <button class="text-blue-600 hover:underline">+ Add date range</button>
                <div class="space-x-4">
                    <button class="bg-gray-100 text-gray-600 px-4 py-2 rounded hover:bg-gray-200">Clear</button>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Search</button>
                </div>
            </div>

            <!-- Session Queries -->
            <div class="mt-8">
                <h2 class="font-semibold text-lg">Session Queries</h2>
                <p class="text-gray-500">Your history is currently empty. All your searches in the current session will
                    appear here.</p>
            </div>
        </div>
    </div>
</x-app-layout>
