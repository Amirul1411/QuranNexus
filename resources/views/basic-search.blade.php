<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Basic Search</title>
</head>
<body class="bg-blue-50 p-8">
    <div class="bg-white shadow-lg rounded-lg p-6 max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-4">
            <div class="flex space-x-6">
                <button class="font-semibold text-blue-600 border-b-2 border-blue-600">SEARCH</button>
                <button class="text-gray-500 hover:text-blue-600">RECITERS</button>
            </div>
        </div>

        <!-- Search Form -->
        <form action="{{ route('search.perform') }}" method="POST">
            @csrf <!-- CSRF Token for Laravel forms -->

            <!-- Select Collection -->
            <div class="mt-4">
                <label class="block font-semibold mb-1">Search in:</label>
                <select name="search_in" class="w-full border border-gray-300 p-2 rounded">
                    <option value="juzs">Juzs</option>
                    <option value="pages">Pages</option>
                    <option value="surahs">Surahs</option>
                    <option value="ayahs">Ayahs</option>
                    <option value="words">Words</option>
                </select>
            </div>

            <!-- Search Fields -->
            <div id="search-rows" class="space-y-4 mt-4">
                <!-- Default First Row -->
                <div class="flex items-center space-x-4">
                    <!-- Text Input -->
                    <input
                        name="conditions[0][value]"
                        type="text"
                        placeholder="Example: Al-Fatihah"
                        class="flex-grow border border-gray-300 p-2 rounded"
                    />
                </div>
            </div>

            <!-- Add Row Button -->
            <div class="mt-4">
                <button id="add-row" type="button" class="text-blue-600 hover:underline">+ Add row</button>
            </div>

            <!-- Submit and Clear Buttons -->
            <div class="mt-4 flex justify-between items-center">
                <!-- Advanced Search Button -->
                <a href="{{ route('advanced-search') }}" class="text-blue-600 hover:underline">Advanced search</a>
                <div class="space-x-4">
                    <button type="reset" class="bg-gray-100 text-gray-600 px-4 py-2 rounded hover:bg-gray-200">Clear</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Search</button>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript for Adding Rows -->
    <script>
        let rowIndex = 1; // Keeps track of row indices for dynamic inputs

        document.getElementById('add-row').addEventListener('click', function () {
            const searchRows = document.getElementById('search-rows');
            const row = document.createElement('div');
            row.classList.add('flex', 'items-center', 'space-x-4', 'mt-2');
            row.innerHTML = `
                <!-- Text Input -->
                <input
                    name="conditions[${rowIndex}][value]"
                    type="text"
                    placeholder="Example: Al-Fatihah"
                    class="flex-grow border border-gray-300 p-2 rounded"
                />
                <!-- Remove Button -->
                <button type="button" class="text-red-600 hover:text-red-800" onclick="this.parentElement.remove()">&minus;</button>
            `;
            searchRows.appendChild(row);
            rowIndex++;
        });
    </script>
</body>
</html>