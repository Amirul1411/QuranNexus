<x-app-layout title="Link Checker">
    <div class="w-full min-h-screen" style="background: linear-gradient(90deg, #86D6C3 0%, #75FF9C 100%); padding-top: 80px; padding-bottom: 80px;">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold text-[#2D6360] text-center mb-6">Link Checker</h1>

            <!-- Display success messages -->
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tab Navigation -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="flex border-b">
                    <button id="check-tab" class="tab-button text-blue-600 font-semibold px-4 py-2 border-b-2 border-blue-600 focus:outline-none">
                        Check Verified Links
                    </button>
                    <button id="submit-tab" class="tab-button text-gray-600 px-4 py-2 border-b-2 focus:outline-none">
                        Submit a Link
                    </button>
                </div>

                <!-- Tab Content -->
                <div id="check-content" class="tab-content p-4">
                    <!-- Check if Link is Verified -->
                    <form action="{{ route('check.link') }}" method="POST" class="mb-6">
                        @csrf
                        <label class="block font-semibold mb-2">Enter Link to Check:</label>
                        <input type="url" name="url" class="w-full border border-gray-300 p-2 rounded" required placeholder="https://example.com">
                        <button type="submit" class="mt-3 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Check Link
                        </button>
                    </form>

                    <!-- Show Link Verification Result -->
                    @if (session('verificationResult'))
                        <div class="mt-4 p-3 rounded {{ session('verificationResult')['status'] == 'verified' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ session('verificationResult')['message'] }}
                        </div>
                    @endif

                    <!-- Verified Sources List -->
                    <h2 class="text-xl font-bold text-[#2D6360] mb-3">Verified Sources</h2>
                    <ul class="space-y-2">
                        @foreach ($verifiedLinks as $link)
                            <li class="border border-gray-300 p-3 rounded">
                                <a href="{{ $link->url }}" target="_blank" class="text-blue-500 underline">
                                    {{ $link->url }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div id="submit-content" class="tab-content p-4 hidden">
                    <!-- Submit a Link for Verification -->
                    <form action="{{ route('submit.link') }}" method="POST">
                        @csrf
                        <label class="block font-semibold mb-2">Submit a New Link:</label>
                        <input type="url" name="url" class="w-full border border-gray-300 p-2 rounded" required placeholder="https://example.com">
                        <button type="submit" class="mt-3 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Submit for Verification
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- JavaScript for Tabs -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkTab = document.getElementById("check-tab");
        const submitTab = document.getElementById("submit-tab");
        const checkContent = document.getElementById("check-content");
        const submitContent = document.getElementById("submit-content");

        checkTab.addEventListener("click", function () {
            checkContent.classList.remove("hidden");
            submitContent.classList.add("hidden");
            checkTab.classList.add("text-blue-600", "border-blue-600");
            checkTab.classList.remove("text-gray-600");
            submitTab.classList.add("text-gray-600");
            submitTab.classList.remove("text-blue-600", "border-blue-600");
        });

        submitTab.addEventListener("click", function () {
            submitContent.classList.remove("hidden");
            checkContent.classList.add("hidden");
            submitTab.classList.add("text-blue-600", "border-blue-600");
            submitTab.classList.remove("text-gray-600");
            checkTab.classList.add("text-gray-600");
            checkTab.classList.remove("text-blue-600", "border-blue-600");
        });
    });
</script>
