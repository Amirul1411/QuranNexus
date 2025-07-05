<x-app-layout title="Manage Experts">
    <div class="w-full min-h-screen" style="background: linear-gradient(90deg, #86D6C3 0%, #75FF9C 100%); padding-top: 80px; padding-bottom: 80px;">
        <div class="max-w-4xl mx-auto">
            <!-- Page Title -->
            <h1 class="text-center text-3xl font-bold text-[#2D6360] mb-6">
                Manage Experts
            </h1>

            <!-- Assign Expert Form -->
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-bold text-[#2D6360] mb-4">Assign an Expert</h2>
                
                <!-- Form to Assign an Expert -->
                <form action="{{ route('expert.assign') }}" method="POST">
                    @csrf

                    <!-- Select Data Type -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Select Data Type:</label>
                        <select name="data_type" class="w-full p-2 border border-gray-300 rounded">
                            <option value="ayah">Ayah</option>
                            <option value="word">Word</option>
                            <option value="translation">Translation</option>
                        </select>
                    </div>

                    <!-- Select Surah and Ayah (Optional) -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Surah ID:</label>
                        <input type="text" name="surah_id" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter Surah ID (Optional)">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Ayah Index:</label>
                        <input type="text" name="ayah_index" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter Ayah Index (Optional)">
                    </div>

                    <!-- Select Expert -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Select Expert:</label>
                        <select name="expert_id" class="w-full p-2 border border-gray-300 rounded">
                            @foreach ($editors as $editor)
                                <option value="{{ $editor->_id }}">{{ $editor->name }} ({{ $editor->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Assign Button -->
                    <div class="flex justify-center">
                        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded shadow hover:bg-green-600">
                            Assign Expert
                        </button>
                    </div>
                </form>
            </div>

            <!-- Assigned Experts List -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-bold text-[#2D6360] mb-4">Assigned Experts</h2>

                @if ($assignments->isEmpty())
                    <p class="text-gray-500">No experts assigned yet.</p>
                @else
                    <ul class="space-y-4">
                        @foreach ($assignments as $assignment)
                            <li class="border border-gray-300 p-4 rounded bg-gray-100">
                                <p><strong>Data Type:</strong> {{ ucfirst($assignment->data_type) }}</p>
                                <p><strong>Surah ID:</strong> {{ $assignment->surah_id ?? 'N/A' }}</p>
                                <p><strong>Ayah Index:</strong> {{ $assignment->ayah_index ?? 'N/A' }}</p>
                                <p><strong>Assigned Expert:</strong> {{ $assignment->expert->name }} ({{ $assignment->expert->email }})</p>
                                
                                <!-- Remove Assignment Button -->
                                <form action="{{ route('expert.unassign', $assignment->_id) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-600">
                                        Remove Assignment
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
