<?php

namespace App\Livewire;

use App\Services\Interfaces\CoingekoApiServiceInterface;
use Livewire\Component;
use Illuminate\Http\Client\RequestException;

class NftShow extends Component
{
    protected CoingekoApiServiceInterface $coingekoApi;

    public string $id;
    public array $nft = [];

    public function boot(CoingekoApiServiceInterface $coingekoApi)
    {
        $this->coingekoApi = $coingekoApi;
    }

    public function mount(string $id)
    {
        $this->id = $id;
        $this->loadNft();
    }

    private function loadNft()
    {
        try {
            $response = $this->coingekoApi->getNftById($this->id)->throw();
            $this->nft = $response->json();
        } catch (RequestException $e) {
            $this->dispatch('showError', message: $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.nft-show');
    }
} 