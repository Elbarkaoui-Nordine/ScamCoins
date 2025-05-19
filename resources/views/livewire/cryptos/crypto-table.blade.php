<div>
    @if($cryptos->isEmpty())
        <div class="text-center py-4 text-gray-400">
            No data available
        </div>
    @else
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-slate-900">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-200 sm:pl-6">#</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-200 min-w-40">Name</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-200">Price</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-200">24h %</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-200">
                                        <button wire:click="sortBy('market_cap')" class="flex items-center hover:text-blue-400">
                                            Market Cap
                                            <x-table.sorting-icon field="market_cap" :order="$order" />
                                        </button>
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-200">
                                        <button wire:click="sortBy('volume')" class="flex items-center hover:text-blue-400">
                                            Volume(24h)
                                            <x-table.sorting-icon field="volume" :order="$order" />
                                        </button>
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-200">Sparkline</th>
                                </tr>
                            </thead>
                            <tbody wire:loading.remove class="divide-y divide-gray-700 bg-slate-900">
                                @forelse($cryptos as $index => $crypto)
                                    <tr class="hover:bg-slate-800 cursor-pointer" data-crypto-id="{{ $crypto['id'] }}">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-200 sm:pl-6">
                                            {{ ($page - 1) * $perPage + (int)$index + 1 }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                                            <div class="flex items-center">
                                                <img src="{{ $crypto['image'] }}" alt="{{ $crypto['name'] }}" class="h-6 w-6 rounded-full">
                                                <span class="ml-2 font-medium text-white">{{ $crypto['name'] }}</span>
                                                <span class="ml-2 text-gray-400">{{ strtoupper($crypto['symbol']) }}</span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">${{ number_format($crypto['current_price'], 2) }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            <span class="{{ $crypto['price_change_percentage_24h'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                                {{ number_format($crypto['price_change_percentage_24h'], 2) }}%
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">${{ number_format($crypto['market_cap']) }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">${{ number_format($crypto['total_volume']) }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                                            @if(isset($crypto['sparkline_in_7d']['price']))
                                                <div class="h-8 w-32">
                                                    <canvas id="sparkline-{{ $crypto['id'] }}"></canvas>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-3 py-4 text-sm text-gray-300 text-center">No cryptocurrencies found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tr>
                                <td colspan="7" class="px-3 py-4 text-sm text-gray-300 text-center">
                                    <div wire:loading class="flex justify-center items-center py-8">
                                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                {{ $cryptos->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', function () {
            const cryptos = @json($cryptos->items());
            
            // Add click handler for table rows
            document.querySelectorAll('tr[data-crypto-id]').forEach(row => {
                row.addEventListener('click', function() {
                    const cryptoId = this.dataset.cryptoId;
                    window.location.href = `/crypto/${cryptoId}`;
                });
            });
            
            cryptos.forEach(crypto => {
                if (crypto.sparkline_in_7d?.price) {
                    const ctx = document.getElementById(`sparkline-${crypto.id}`).getContext('2d');
                    const color = crypto.price_change_percentage_24h >= 0 ? '#34d399' : '#f87171';
                    
                    const sparklineData = crypto.sparkline_in_7d.price.filter(price => price !== null);
                    
                    if (sparklineData.length > 0) {
                        const min = Math.min(...sparklineData);
                        const max = Math.max(...sparklineData);
                        const padding = (max - min) * 0.1; // 10% padding
                        
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: Array(sparklineData.length).fill(''),
                                datasets: [{
                                    data: sparklineData,
                                    borderColor: color,
                                    borderWidth: 1.5,
                                    pointRadius: 0,
                                    tension: 0.4,
                                    fill: false
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        enabled: false
                                    }
                                },
                                scales: {
                                    x: {
                                        display: false
                                    },
                                    y: {
                                        display: false,
                                        min: min - padding,
                                        max: max + padding
                                    }
                                },
                                interaction: {
                                    intersect: false,
                                    mode: 'index'
                                },
                                elements: {
                                    line: {
                                        borderWidth: 1.5
                                    }
                                }
                            }
                        });
                    }
                }
            });
        });
    </script>
</div> 