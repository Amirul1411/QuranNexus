<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Search Results</title>
</head>
<body class="bg-blue-50 p-8">
    <a href="{{ route('basic-search') }}" class="text-blue-600 hover:underline mt-4 block">Back to Search</a>
    <div class="bg-white shadow-lg rounded-lg p-6 max-w-4xl mx-auto">
        <h1 class="text-xl font-bold mb-4">Search Results</h1>
        <p class="mb-2 text-gray-500">Collection: <strong>{{ ucfirst($searchIn) }}</strong></p>

        @if ($results->isEmpty())
            <p>No results found.</p>
        @else
            <ul class="space-y-2">
                @foreach ($results as $result)
                    <li class="border border-gray-300 p-4 rounded">
                        <!-- Display all fields dynamically -->
                        @foreach ($result->toArray() as $key => $value)
                            <p><strong>{{ ucfirst($key) }}:</strong> {{ is_array($value) ? json_encode($value) : $value }}</p>
                        @endforeach
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</body>
</html>