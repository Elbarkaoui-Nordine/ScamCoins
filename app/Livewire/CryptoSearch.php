<?php

namespace App\Livewire;

use App\Services\Interfaces\CoingekoApiServiceInterface;
use Livewire\Component;

class CryptoSearch extends Component
{
    protected CoingekoApiServiceInterface $coingekoApi;

    public $search = '';
    public $results = [];
    public $loading = false;

    public function boot(CoingekoApiServiceInterface $coingekoApi)
    {
        $this->coingekoApi = $coingekoApi;
    }

    public function performSearch()
    {
        if (!$this->search) {
            $this->results = [];
            return;
        }

        $this->loading = true;

        try {
            $response = $this->coingekoApi->searchCrypto($this->search);
            $this->results = $response->json('coins');
        } catch (\Exception $e) {
            $this->results = [];
            $this->dispatch('showError', message: $e->getMessage());
        } 
        $this->loading = false;   
    }
    
    public function render()
    {
        return view('livewire.crypto-search');
    }
}
