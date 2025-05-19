<?php

namespace App\Livewire;

use App\Services\Interfaces\CoingekoApiServiceInterface;
use Livewire\Component;
use Illuminate\Http\Client\RequestException;

class CryptoShow extends Component
{
    protected CoingekoApiServiceInterface $coingekoApi;

    public string $id;
    public array $crypto = [];
    public array $historicalData = [];
    public string $timeRange = '7d';


    public function boot(CoingekoApiServiceInterface $coingekoApi)
    {
        $this->coingekoApi = $coingekoApi;
    }

    public function mount(string $id)
    {
        $this->id = $id;
        $this->loadCrypto();
        $this->loadHistoricalData();
    }

    private function loadCrypto()
    {
        try {
            $response = $this->coingekoApi->getCryptoById($this->id)->throw();
            $this->crypto = $response->json();
        } catch (RequestException $e) {
            $this->dispatch('showError', message: $e->getMessage());
        }
    }

    private function loadHistoricalData()
    {
        try {
            $days = match($this->timeRange) {
                '7d' => '7',
                '30d' => '30',
                default => '7'
            };

            $response = $this->coingekoApi->get("/coins/{$this->id}/market_chart", [
                'vs_currency' => 'usd',
                'days' => $days,
                'interval' => $days === '1' ? 'hourly' : 'daily'
            ])->throw();
            
            $this->historicalData = $response->json();
            $this->dispatch('historicalDataUpdated', ['prices' => $this->historicalData['prices']]);
        } catch (RequestException $e) {
            $this->dispatch('showError', message: $e->getMessage());
        }
    }

    public function updateTimeRange($range)
    {
        $this->timeRange = $range;
        $this->loadHistoricalData();
    }

    public function render()
    {
        return view('livewire.cryptos.crypto-show');
    }
} 