<div>

    <!-- 3D Scatter Plot (Hidden by Default) -->
    <div wire:ignore class="flex justify-center items-center w-full">
        <div id="3dScatterPlot" class="my-5 w-100 h-100"></div>
    </div>

    <!-- Table -->
    {{ $this->table }}

    <x-filament-actions::modals />
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', function() {
            Livewire.on('longestTokenSelected', ({
                longestToken
            }) => {
                var myPlot = document.getElementById('3dScatterPlot');

                // Render the plot
                var data = [];

                // Define a color scale for each length
                const colorScale = {
                    8: 'blue',
                    9: 'green',
                    10: 'red',
                    11: 'purple',
                };

                // Group tokens by length
                const groupedTokens = {};
                longestToken.forEach(token => {
                    if (!groupedTokens[token.length]) {
                        groupedTokens[token.length] = [];
                    }
                    groupedTokens[token.length].push(token);
                });

                // Create a trace for each length
                Object.keys(groupedTokens).forEach(length => {
                    const tokens = groupedTokens[length];
                    const x = [],
                        y = [],
                        z = [],
                        text = [],
                        lengths = [];

                    tokens.forEach(token => {
                        x.push(token
                        .surah_id); // or Number(surah_id) if you want it as a number
                        y.push(token
                        .ayah_index); // or Number(ayah_index) if you want it as a number
                        z.push(token
                        .word_index); // or Number(word_index) if you want it as a number
                        text.push(token.text); // Token text
                        lengths.push(token.length); // Token length
                    });

                    const trace = {
                        x: x,
                        y: y,
                        z: z,
                        mode: 'markers',
                        marker: {
                            size: 12,
                            color: colorScale[length], // Assign color based on length
                            line: {
                                color: 'rgba(217, 217, 217, 0.14)',
                                width: 0.5
                            },
                            opacity: 0.8
                        },
                        type: 'scatter3d',
                        hovertemplate: '<b>Surah ID: </b> %{x}' +
                            '<br><b>Ayah Index: </b> %{y}<br>' +
                            '<b>Word Index: </b> %{z}<br>' +
                            '<b>Longest Token: </b> %{text}<br>' +
                            '<b>Length: </b> %{customdata}<br>' +
                            '<extra></extra>',
                        text: text,
                        customdata: lengths,
                        name: `Length ${length}`, // Name for the legend (different for each trace)
                        showlegend: true // Show legend for this trace
                    };

                    data.push(trace);
                });

                var layout = {
                    title: {
                        text: '3D Scatter Plot for Longest Token',
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
                    showlegend: true // Ensure the legend is shown
                };

                Plotly.react('3dScatterPlot', data, layout);

                myPlot.on('plotly_click', function(data) {
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
