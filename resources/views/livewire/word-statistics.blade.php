<div x-data="{ showPlot: false }" x-on:show-plot.window="showPlot = true">

    <!-- 3D Scatter Plot (Hidden by Default) -->
    <div wire:ignore x-show="showPlot" class="flex justify-center items-center w-full">
        <div id="3dScatterPlot" class="my-5 w-100 h-100"></div>
    </div>

    <!-- Table -->
    {{ $this->table }}

    <x-filament-actions::modals />
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', function() {
            Livewire.on('wordStatisticsSelected', ({
                wordStatistics
            }) => {

                var myPlot = document.getElementById('3dScatterPlot');

                // Render the plot (same as above)
                var x = [],
                    y = [],
                    z = [];

                Livewire.dispatch('show-plot');

                wordStatistics.positions.word_keys.forEach(word_key => {
                    var [surah_id, ayah_index, word_index] = word_key.split(':');
                    x.push(surah_id); // or Number(surah_id) if you want it as a number
                    y.push(ayah_index); // or Number(ayah_index) if you want it as a number
                    z.push(word_index); // or Number(word_index) if you want it as a number
                });

                var trace = {
                    x: x,
                    y: y,
                    z: z,
                    mode: 'markers',
                    marker: {
                        size: 12,
                        line: {
                            color: 'rgba(217, 217, 217, 0.14)',
                            width: 0.5
                        },
                        opacity: 0.8
                    },
                    type: 'scatter3d',
                    hovertemplate:
                        '<b>Surah ID:</b> %{x}' +
                        '<br><b>Ayah Index:</b> %{y}<br>' +
                        '<b>Word Index:</b> %{z}<br>' +
                        '<extra></extra>',
                };

                var data = [trace];

                var layout = {
                    title: {
                        text: `3D Scatter Plot for Word Statistics: ${wordStatistics.word}`,
                    },
                    scene: {
                        xaxis: {
                            title: {
                                text: 'Surah ID'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Ayah Index'
                            }
                        },
                        zaxis: {
                            title: {
                                text: 'Word Index'
                            }
                        },
                    },
                    margin: {
                        l: 0,
                        r: 0,
                        b: 0,
                        t: 50,
                    },
                };

                Plotly.react('3dScatterPlot', data, layout);

                myPlot.on('plotly_click', function(data){

                    Livewire.dispatch('plot-clicked', {
                        surahNumber: data.points[0].x,
                        verseNumber: data.points[0].y,
                        tokenNumber: data.points[0].z,
                    });
                });
            });
        });
    </script>
@endpush

