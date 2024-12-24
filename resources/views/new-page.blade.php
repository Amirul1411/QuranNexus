<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Page</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8">
        <h1 class="text-4xl font-bold text-blue-600 mb-4">Welcome to the New Page!</h1>
        <p class="text-gray-700 text-lg">This is the content of your new Laravel page, styled with Tailwind CSS meow.</p>
        <div class="font-sans text-gray-900 antialiased mt-6">
            @yield('content')
        </div>
    </div>
</body>
</html>