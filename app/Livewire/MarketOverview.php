<?php

namespace App\Livewire;

use App\Services\Interfaces\CoingekoApiServiceInterface;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class MarketOverview extends Component
{
    public array $trendingCoins = [];
    public array $trendingNfts = [];
    public array $trendingCategories = [];
    public ?string $errorMessage = null;

    protected CoingekoApiServiceInterface $coingekoApi;
    private const CACHE_TTL = 600; // 10 minutes in seconds
    private const CACHE_KEY = 'trending_data';

    public function mount(CoingekoApiServiceInterface $coingekoApi)
    {
        $this->coingekoApi = $coingekoApi;
        $this->loadTrendingData();
    }

    private function loadTrendingData()
    {
        try {
            $cachedData = Cache::get(self::CACHE_KEY);
            
            if ($cachedData) {
                $this->trendingCoins = $cachedData['coins'];
                $this->trendingNfts = $cachedData['nfts'];
                $this->trendingCategories = $cachedData['categories'];
                return;
            }

            $response = $this->coingekoApi->getTrending();
            $data = $response->json();

            $trendingData = [
                'coins' => array_slice($data['coins'], 0, 15),
                'nfts' => array_slice($data['nfts'], 0, 7),
                'categories' => array_slice($data['categories'], 0, 5)
            ];

            Cache::put(self::CACHE_KEY, $trendingData, self::CACHE_TTL);

            $this->trendingCoins = $trendingData['coins'];
            $this->trendingNfts = $trendingData['nfts'];
            $this->trendingCategories = $trendingData['categories'];
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.market-overview');
    }
} 