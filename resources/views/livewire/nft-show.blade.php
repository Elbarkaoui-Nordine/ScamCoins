<div>
    @if (!empty($nft))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-slate-900 rounded-lg shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-700">
                    <div class="flex items-center space-x-4">
                        <img src="{{ $nft['image']['small_2x'] ?? $nft['image']['small'] }}" alt="{{ $nft['name'] }}" class="h-16 w-16">
                        <div>
                            <h1 class="text-2xl font-bold text-white">{{ $nft['name'] }}</h1>
                            <p class="text-gray-400">{{ $nft['symbol'] }}</p>
                        </div>
                        <div class="ml-auto">
                            <p class="text-3xl font-bold text-white">${{ number_format($nft['floor_price']['usd'], 0) }}</p>
                            <p class="text-sm {{ $nft['floor_price_24h_percentage_change']['usd'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                {{ number_format($nft['floor_price_24h_percentage_change']['usd'], 2) }}%
                            </p>
                        </div>
                    </div>
                </div>

                <div class="lg:grid-cols-2 gap-6 p-6 items-start">
                    <!-- Left Column: Info -->
                    <div class="space-y-6">
                        <!-- Market Data -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-800 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-400">Market Cap</h3>
                                <p class="mt-1 text-lg font-semibold text-white">${{ number_format($nft['market_cap']['usd']) }}</p>
                            </div>
                            <div class="bg-slate-800 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-400">24h Volume</h3>
                                <p class="mt-1 text-lg font-semibold text-white">${{ number_format($nft['volume_24h']['usd']) }}</p>
                            </div>
                            <div class="bg-slate-800 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-400">Total Supply</h3>
                                <p class="mt-1 text-lg font-semibold text-white">{{ $nft['total_supply'] }} {{ $nft['symbol'] }}</p>
                            </div>
                            <div class="bg-slate-800 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-400">Unique Holders</h3>
                                <p class="mt-1 text-lg font-semibold text-white">{{ $nft['number_of_unique_addresses'] }}</p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="bg-slate-800 rounded-lg p-4">
                            <h2 class="text-xl font-semibold text-white mb-4">About {{ $nft['name'] }}</h2>
                            <div class="prose prose-invert max-w-none text-white max-h-[300px] overflow-y-auto">
                                {{ $nft['description'] }}
                            </div>
                        </div>

                        <!-- Links -->
                        <div class="bg-slate-800 rounded-lg p-4">
                            <h2 class="text-xl font-semibold text-white mb-4">Links</h2>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                @if (!empty($nft['links']['homepage']))
                                    <a href="{{ $nft['links']['homepage'] }}" target="_blank" class="text-blue-400 hover:text-blue-300">
                                        {{ parse_url($nft['links']['homepage'], PHP_URL_HOST) }}
                                    </a>
                                @else
                                    <p class="text-gray-400">No homepage found</p>
                                @endif

                                @foreach ($nft['explorers'] as $explorer)
                                    <a href="{{ $explorer['link'] }}" target="_blank" class="text-blue-400 hover:text-blue-300">
                                        {{ $explorer['name'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-4 text-gray-400">
            No data available
        </div>
    @endif
</div>
