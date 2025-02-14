<div class="flex justify-end items-center my-5 text-black">
    @if (Route::is('surah.show'))
        <div wire:click="playAudioRecitation({{ $surah->ayahs }})" class="flex w-auto items-center cursor-pointer transform transition-transform duration-300 hover:scale-125">
            <span class="mr-1 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" class="size-5">
                    <path
                        d="M6.3 2.84A1.5 1.5 0 0 0 4 4.11v11.78a1.5 1.5 0 0 0 2.3 1.27l9.344-5.891a1.5 1.5 0 0 0 0-2.538L6.3 2.841Z" />
                </svg>
            </span>
            <p class="cursor-pointer">{{ __('recitation.play_audio') }}</p>
        </div>
    @elseif (Route::is('page.show'))
        <div wire:click="playAudioRecitation({{ $page->ayahs }})" class="flex w-auto items-center cursor-pointer transform transition-transform duration-300 hover:scale-125">
            <span class="mr-1 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" class="size-5">
                    <path
                        d="M6.3 2.84A1.5 1.5 0 0 0 4 4.11v11.78a1.5 1.5 0 0 0 2.3 1.27l9.344-5.891a1.5 1.5 0 0 0 0-2.538L6.3 2.841Z" />
                </svg>
            </span>
            <p class="cursor-pointer">{{ __('recitation.play_audio') }}</p>
        </div>
    @elseif (Route::is('juz.show'))
        <div wire:click="playAudioRecitation({{ $juz->ayahs }})" class="flex w-auto items-center cursor-pointer transform transition-transform duration-300 hover:scale-125">
            <span class="mr-1 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" class="size-5">
                    <path
                        d="M6.3 2.84A1.5 1.5 0 0 0 4 4.11v11.78a1.5 1.5 0 0 0 2.3 1.27l9.344-5.891a1.5 1.5 0 0 0 0-2.538L6.3 2.841Z" />
                </svg>
            </span>
            <p class="cursor-pointer">{{ __('recitation.play_audio') }}</p>
        </div>
    @endif
    <!-- Display the single audio player for the combined audio file -->
    @if (!empty($audioFile))
        <div>
            <audio controls>
                <source src="{{ $audioFile }}" type="audio/mpeg" autoplay>
            </audio>
        </div>
        {{-- <div
            class="bg-black fixed opacity-100 w-full inset-x-0 bottom-0 text-center transition-all z-50 shadow-lg border-t border-gray-200 h-14 will-change-transform">
            <audio class="hidden" id="audio-player" autoplay preload="auto" src="{{ $audioFile }}"></audio>
            <div class="flex justify-center items-center space-x-2 px-2">
                <div class="w-full">

                    <!-- Time and Progress Bar -->
                    <div class="flex justify-between text-xs text-gray-500 transition-all min-h-[1rem]">
                        <span id="current-time" class="inline-block leading-normal text-white">00:00</span>
                        <div
                            class="inline-block w-full h-[1.25rem] transition-all fixed bottom-14 left-1/2 transform -translate-x-1/2">
                            <span dir="ltr" aria-disabled="false" class="flex items-center select-none">
                                <span id="progress-bar-background"
                                    class="relative flex-grow h-[1px] bg-gray-200 opacity-25">
                                    <span id="progress-bar"
                                        class="absolute inset-y-0 bg-gray-400 opacity-30 w-[0%]"></span>
                                </span>
                            </span>
                        </div>
                        <span id="total-duration" class="inline-block leading-normal text-white">00:00:00</span>
                    </div>


                    <!-- Progress Bar with Slider -->
                    <div
                        class="inline-block w-full h-[1.25rem] transition-all fixed bottom-14 left-1/2 transform -translate-x-1/2">
                        <span dir="ltr" aria-disabled="false" class="flex items-center select-none">
                            <span id="progress-bar-background-slider"
                                class="relative flex-grow h-[1px] bg-gray-200 opacity-25">
                                <span id="progress-bar-slider" class="absolute inset-y-0 bg-gray-800 w-[0%]"></span>
                            </span>
                            <span id="slider-handle" class="absolute left-0">
                                <span role="slider" aria-valuemin="0" aria-valuemax="3757"
                                    aria-orientation="horizontal" tabindex="0"
                                    class="block w-4 h-4 bg-black shadow rounded-full"></span>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex justify-center items-center space-x-2">
                <div>
                    <button id="audio-player-overflow-menu-trigger"
                        class="w-10 h-10 bg-transparent border-none text-gray-500 rounded-full flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 text-white">
                            <path fill-rule="evenodd"
                                d="M4.5 12a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Zm6 0a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Zm6 0a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z"
                                clip-rule="evenodd" />
                        </svg>

                    </button>
                </div>
                <div>
                    <button
                        class="w-10 h-10 bg-transparent border-none text-gray-500 rounded-full flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 text-white">
                            <path
                                d="M13.5 4.06c0-1.336-1.616-2.005-2.56-1.06l-4.5 4.5H4.508c-1.141 0-2.318.664-2.66 1.905A9.76 9.76 0 0 0 1.5 12c0 .898.121 1.768.35 2.595.341 1.24 1.518 1.905 2.659 1.905h1.93l4.5 4.5c.945.945 2.561.276 2.561-1.06V4.06ZM18.584 5.106a.75.75 0 0 1 1.06 0c3.808 3.807 3.808 9.98 0 13.788a.75.75 0 0 1-1.06-1.06 8.25 8.25 0 0 0 0-11.668.75.75 0 0 1 0-1.06Z" />
                            <path
                                d="M15.932 7.757a.75.75 0 0 1 1.061 0 6 6 0 0 1 0 8.486.75.75 0 0 1-1.06-1.061 4.5 4.5 0 0 0 0-6.364.75.75 0 0 1 0-1.06Z" />
                        </svg>

                    </button>
                </div>
                <div>
                    <button disabled
                        class="w-10 h-10 bg-transparent border-none text-gray-500 rounded-full flex justify-center items-center opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 text-white">
                            <path
                                d="M9.195 18.44c1.25.714 2.805-.189 2.805-1.629v-2.34l6.945 3.968c1.25.715 2.805-.188 2.805-1.628V8.69c0-1.44-1.555-2.343-2.805-1.628L12 11.029v-2.34c0-1.44-1.555-2.343-2.805-1.628l-7.108 4.061c-1.26.72-1.26 2.536 0 3.256l7.108 4.061Z" />
                        </svg>

                    </button>
                </div>
                <div>
                    <button
                        class="w-10 h-10 bg-transparent border-none text-gray-500 rounded-full flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 text-white">
                            <path fill-rule="evenodd"
                                d="M4.5 5.653c0-1.427 1.529-2.33 2.779-1.643l11.54 6.347c1.295.712 1.295 2.573 0 3.286L7.28 19.99c-1.25.687-2.779-.217-2.779-1.643V5.653Z"
                                clip-rule="evenodd" />
                        </svg>


                    </button>
                </div>
                <div>
                    <button
                        class="w-10 h-10 bg-transparent border-none text-gray-500 rounded-full flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 text-white">
                            <path
                                d="M5.055 7.06C3.805 6.347 2.25 7.25 2.25 8.69v8.122c0 1.44 1.555 2.343 2.805 1.628L12 14.471v2.34c0 1.44 1.555 2.343 2.805 1.628l7.108-4.061c1.26-.72 1.26-2.536 0-3.256l-7.108-4.061C13.555 6.346 12 7.249 12 8.689v2.34L5.055 7.061Z" />
                        </svg>

                    </button>
                </div>
                <div>
                    <button
                        class="w-10 h-10 bg-transparent border-none text-gray-500 rounded-full flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 text-white">
                            <path fill-rule="evenodd"
                                d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>

                    </button>
                </div>
            </div>
        </div>
        <script>
            console.log('test');

            document.addEventListener('livewire:load', function() {

                console.log('test');

                const audioPlayer = document.getElementById('audio-player');
                const currentTimeSpan = document.getElementById('current-time');
                const totalDurationSpan = document.getElementById('total-duration');
                const progressBar = document.getElementById('progress-bar');
                const progressBarSlider = document.getElementById('progress-bar-slider');
                const sliderHandle = document.getElementById('slider-handle');

                // Log elements to ensure they exist
                console.log({
                    audioPlayer,
                    currentTimeSpan,
                    totalDurationSpan,
                    progressBar,
                    progressBarSlider,
                    sliderHandle
                });

                if (!audioPlayer) {
                    console.error('Audio player element not found.');
                    return;
                }

                // Format time in HH:MM:SS or MM:SS
                function formatTime(seconds) {
                    const h = Math.floor(seconds / 3600);
                    const m = Math.floor((seconds % 3600) / 60);
                    const s = Math.floor(seconds % 60);
                    return h > 0 ? `${h}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}` :
                        `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                }

                // Update the current time display and progress bar
                audioPlayer.addEventListener('timeupdate', function() {
                    console.log('Current time:', audioPlayer.currentTime);
                    currentTimeSpan.textContent = formatTime(audioPlayer.currentTime);

                    const progressPercent = (audioPlayer.currentTime / audioPlayer.duration) * 100;
                    progressBar.style.width = progressPercent + '%';
                    progressBarSlider.style.width = progressPercent + '%';
                    sliderHandle.style.left = `calc(${progressPercent}% - 6.48074px)`;
                });

                // Display the total duration once the metadata is loaded
                audioPlayer.addEventListener('loadedmetadata', function() {
                    console.log('Audio metadata loaded:', audioPlayer.duration);
                    totalDurationSpan.textContent = formatTime(audioPlayer.duration);
                });

                document.addEventListener('livewire:update', function() {
                    console.log('Livewire updated. Reinitializing audio player...');
                    setupAudioPlayer(); // Re-initialize after Livewire updates
                });
            });
        </script> --}}
    @endif
</div>
