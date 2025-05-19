<?php

namespace App\Livewire;

use App\Services\Interfaces\CoingekoApiServiceInterface;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Url;
use Illuminate\Http\Client\RequestException;

class NftTable extends Component
{
    use WithPagination;

    protected CoingekoApiServiceInterface $coingekoApi;

    #[Url(history: true)]
    public int $page = 1;
    public int $perPage = 20;

    public function boot(CoingekoApiServiceInterface $coingekoApi)
    {
        $this->coingekoApi = $coingekoApi;
    }

    private function getNfts(): LengthAwarePaginator
    {
        try {
            $response = $this->coingekoApi->getNfts([
                'per_page' => $this->perPage,
                'page' => $this->page,
            ])->throw();

            $total = $response->header('total');
            $data = collect($response->json());

            return new LengthAwarePaginator(
                $data,
                $total,
                $this->perPage,
                $this->page,
                ['path' => request()->url()]
            );
        } catch (RequestException $e) {
            $this->dispatch('showError', message: $e->getMessage());
            return new LengthAwarePaginator([], 0, $this->perPage, null);
        }
    }

    public function render()
    {
        return view('livewire.nfts.nft-table', [
            'nfts' => $this->getNfts()
        ]);
    }
} 