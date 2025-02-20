<x-app-layout title="Verify Links">
    <div class="w-full min-h-screen" style="background: linear-gradient(90deg, #86D6C3 0%, #75FF9C 100%); padding-top: 80px; padding-bottom: 80px;">
        <div class="max-w-4xl mx-auto">
            <!-- Back Button -->
            <a href="{{ route('link.checker') }}" class="text-blue-600 hover:underline mt-4 block">
                &larr; Back to Link Checker
            </a>

            <!-- Verification Section -->
            <div class="bg-white shadow-lg rounded-lg p-6 mt-4">
                <h1 class="text-2xl font-bold text-[#2D6360] mb-4">Verify Submitted Links</h1>

                @if (session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($links->isEmpty())
                    <p class="text-gray-500">No pending links for verification.</p>
                @else
                    <ul class="space-y-4">
                        @foreach ($links as $link)
                            <li class="border border-gray-300 p-4 rounded">
                                <p><strong>URL:</strong> 
                                    <a href="{{ $link->url }}" target="_blank" class="text-blue-500 underline">
                                        {{ $link->url }}
                                    </a>
                                </p>
                                
                                <p><strong>Submitted By:</strong> 
                                    {{ is_array($link->submitted_by) ? implode(', ', $link->submitted_by) : $link->submitted_by }}
                                </p>

                                {{-- <p><strong>Submitted At:</strong> 
                                    @if(is_array($link->submitted_at))
                                        @foreach ($link->submitted_at as $time)
                                            {{ \Carbon\Carbon::parse($time)->format('Y-m-d H:i:s') }}<br>
                                        @endforeach
                                    @else
                                        {{ \Carbon\Carbon::parse($link->submitted_at)->format('Y-m-d H:i:s') }}
                                    @endif
                                </p> --}}

                                <div class="flex space-x-4 mt-2">
                                    <form action="{{ route('verify.link', ['id' => $link->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                            Verify
                                        </button>
                                    </form>

                                    <form action="{{ route('reject.link', ['id' => $link->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
