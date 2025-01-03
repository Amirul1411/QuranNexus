<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel Website')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-[#2D6360] text-white py-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('ayah.index') }}" class="text-2xl font-bold flex items-center">
                <span class="text-white">Quran Nexus</span>
            </a>

            <!-- Navigation Links -->
            <ul id="menu" class="hidden md:flex items-center space-x-8 ml-auto">
                <li>
                    <a href="{{ route('ayah.index') }}" 
                        class="hover:underline hover:text-[#4CAF50] transition">
                        Ayah
                    </a>
                </li>
                <li>
                    <a href="{{ route('word.index') }}" 
                        class="hover:underline hover:text-[#4CAF50] transition">
                        Word
                    </a>
                </li>
                <li>
                    <a href="{{ route('basic-search') }}" 
                        class="hover:underline hover:text-[#4CAF50] transition">
                        Search
                    </a>
                </li>
            </ul>

            <!-- Mobile Menu Button -->
            <button id="menu-toggle" class="block md:hidden text-white focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <ul id="mobile-menu" class="md:hidden bg-[#2D6360] space-y-4 p-4 hidden">
            <li>
                <a href="{{ route('ayah.index') }}" 
                    class="hover:underline hover:text-[#4CAF50] transition block">
                    Ayah
                </a>
            </li>
            <li>
                <a href="{{ route('word.index') }}" 
                    class="hover:underline hover:text-[#4CAF50] transition block">
                    Word
                </a>
            </li>
            <li>
                <a href="{{ route('basic-search') }}" 
                    class="hover:underline hover:text-[#4CAF50] transition block">
                    Search
                </a>
            </li>
        </ul>
    </nav>

    <!-- Page Content -->
    <div class="container mx-auto mt-8">
        @yield('content')
    </div>

    <script>
        // JavaScript for toggling mobile menu
        const menuToggle = document.getElementById('menu-toggle');
        const menu = document.getElementById('menu');
        const mobileMenu = document.getElementById('mobile-menu');

        menuToggle.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
