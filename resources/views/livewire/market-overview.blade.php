<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gray-700 rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-white mb-4">Trending Coins 🔥</h2>
            <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
                @foreach($trendingCoins as $coin)
                    <a href="{{ route('crypto.show', $coin['item']['id']) }}" class="block hover:bg-gray-600 rounded-lg p-3 transition-colors">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $coin['item']['thumb'] }}" alt="{{ $coin['item']['name'] }}" class="w-8 h-8 rounded-full">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-white">{{ $coin['item']['name'] }}</p>
                                <p class="text-xs text-gray-400">{{ strtoupper($coin['item']['symbol']) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-300">Rank #{{ $coin['item']['market_cap_rank'] }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="bg-gray-700 rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-white mb-4">Trending NFTs 🃏</h2>
            <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
                @foreach($trendingNfts as $nft)
                    <a href="{{ route('nft.show', $nft['id']) }}" class="block hover:bg-gray-600 rounded-lg p-3 transition-colors">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $nft['thumb'] }}" alt="{{ $nft['name'] }}" class="w-8 h-8 rounded-full">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-white">{{ $nft['name'] }}</p>
                                <p class="text-xs text-gray-400">{{ $nft['symbol'] }}</p>
                            </div>
                            <div class="text-right space-y-1">
                                <p class="text-sm text-gray-300">{{ $nft['data']['floor_price'] }}</p>
                                <p class="text-xs {{ $nft['data']['floor_price_in_usd_24h_percentage_change'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                    {{ number_format($nft['data']['floor_price_in_usd_24h_percentage_change'], 2) }}%
                                </p>
                                <p class="text-xs text-gray-400">Vol: {{ $nft['data']['h24_volume'] }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="bg-gray-700 rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-white mb-4">Trending Categories 📊</h2>
            <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
                @foreach($trendingCategories as $category)
                    <div class="hover:bg-gray-600 rounded-lg p-3 transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-white">{{ $category['name'] }}</p>
                                <div class="flex items-center space-x-2">
                                    <p class="text-xs text-gray-400">{{ number_format($category['coins_count']) }} coins</p>
                                    <span class="text-gray-600">•</span>
                                    <p class="text-xs text-gray-400">Vol: ${{ number_format($category['data']['total_volume'], 0) }}</p>
                                </div>
                            </div>
                            <div class="text-right space-y-1">
                                <p class="text-sm text-gray-300">${{ number_format($category['data']['market_cap'] / 1000000, 1) }}M</p>
                                <p class="text-xs {{ $category['data']['market_cap_change_percentage_24h']['usd'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                    {{ number_format($category['data']['market_cap_change_percentage_24h']['usd'], 2) }}%
                                </p>
                                <p class="text-xs text-gray-400">1h: {{ number_format($category['market_cap_1h_change'], 2) }}%</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

