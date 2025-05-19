<div>
    @if (!empty($crypto))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-slate-900 rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-700">
                    <div class="flex items-center space-x-4">

                        <img src="{{ $crypto['image']['large'] }}" alt="{{ $crypto['name'] }}" class="h-16 w-16">
                        <div>
                            <h1 class="text-2xl font-bold text-white">{{ $crypto['name'] }}</h1>
                            <p class="text-gray-400">{{ strtoupper($crypto['symbol']) }}</p>
                        </div>
                        <div class="ml-auto">
                            <p class="text-3xl font-bold text-white">${{ number_format($crypto['market_data']['current_price']['usd'], 2) }}</p>
                            <p class="text-sm {{ $crypto['market_data']['price_change_percentage_24h'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                {{ number_format($crypto['market_data']['price_change_percentage_24h'], 2) }}%
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6 items-start">
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-800 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-400">Market Cap</h3>
                                <p class="mt-1 text-lg font-semibold text-white">${{ number_format($crypto['market_data']['market_cap']['usd']) }}</p>
                            </div>
                            <div class="bg-slate-800 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-400">24h Volume</h3>
                                <p class="mt-1 text-lg font-semibold text-white">${{ number_format($crypto['market_data']['total_volume']['usd']) }}</p>
                            </div>
                            <div class="bg-slate-800 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-400">Circulating Supply</h3>
                                <p class="mt-1 text-lg font-semibold text-white">{{ number_format($crypto['market_data']['circulating_supply']) }} {{ strtoupper($crypto['symbol']) }}</p>
                            </div>
                            <div class="bg-slate-800 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-400">Total Supply</h3>
                                <p class="mt-1 text-lg font-semibold text-white">{{ number_format($crypto['market_data']['total_supply']) }} {{ strtoupper($crypto['symbol']) }}</p>
                            </div>
                        </div>

                        <div class="bg-slate-800 rounded-lg p-4">
                            <h2 class="text-xl font-semibold text-white mb-4">About {{ $crypto['name'] }}</h2>
                            <div class="prose prose-invert max-w-none text-white max-h-[300px] overflow-y-auto">
                                {!! $crypto['description']['en'] !!}
                            </div>
                        </div>

                        <div class="bg-slate-800 rounded-lg p-4">
                            <h2 class="text-xl font-semibold text-white mb-4">Links</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if(isset($crypto['links']['homepage']))
                                    @foreach($crypto['links']['homepage'] as $link)
                                        @if($link)
                                            <a href="{{ $link }}" target="_blank" class="text-blue-400 hover:text-blue-300">
                                                {{ parse_url($link, PHP_URL_HOST) }}
                                            </a>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-gray-400">No links found</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-800 rounded-lg p-4">
                        <div class="flex flex-col ">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-semibold text-white">Price Chart</h2>
                                <div class="flex space-x-2">
                                    <button wire:click="updateTimeRange('7d')" class="px-3 py-1 text-sm rounded {{ $timeRange === '7d' ? 'bg-blue-500 text-white' : 'bg-slate-700 text-gray-300' }}">7D</button>
                                    <button wire:click="updateTimeRange('30d')" class="px-3 py-1 text-sm rounded {{ $timeRange === '30d' ? 'bg-blue-500 text-white' : 'bg-slate-700 text-gray-300' }}">30D</button>
                                </div>
                            </div>
                            <div class="relative h-[400px]">
                                <canvas id="priceChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let chart;
        
            document.addEventListener('livewire:initialized', function () {
                initChart(@json($historicalData['prices'] ?? []));
            });
        
            function initChart(prices) {
                const ctx = document.getElementById('priceChart').getContext('2d');
                const labels = prices.map(price => new Date(price[0]).toLocaleDateString());
                const data = prices.map(price => price[1]);
        
                // Destroy existing chart if it exists
                if (chart) {
                    chart.destroy();
                }
        
                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Price (USD)',
                            data: data,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                },
                                ticks: {
                                    color: '#9ca3af'
                                }
                            },
                            y: {
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                },
                                ticks: {
                                    color: '#9ca3af',
                                    callback: function(value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            }
        
            Livewire.on('historicalDataUpdated', (data) => {
                const prices = data[0].prices;
                initChart(prices); // destroy and reinit
            });
        </script>
        
    @else
        <div class="text-center py-4 text-gray-400">
            No data available
        </div>
    @endif
</div> 