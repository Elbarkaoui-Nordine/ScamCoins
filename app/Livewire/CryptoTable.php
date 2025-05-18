<?php

namespace App\Livewire;

use App\Services\Interfaces\CoingekoApiServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class CryptoTable extends Component
{
    use WithPagination;

    protected CoingekoApiServiceInterface $coingekoApi;

    #[Url(history: true)]
    public int $page = 1;
    public int $perPage = 20;
    #[Url(history: true)]
    public string $order = 'market_cap_desc';

    public function boot(CoingekoApiServiceInterface $coingekoApi)
    {
        $this->coingekoApi = $coingekoApi;
    }

    public function sortBy(string $field)
    {
        $this->order = $this->order === "{$field}_asc" ? "{$field}_desc" : "{$field}_asc";
        $this->resetPage();
    }

    private function getCryptos(): LengthAwarePaginator
    {
        try {
            $response = $this->coingekoApi->getCryptos([
                'order' => $this->order,
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

    private function calculateSparklinePoints($prices)
    {
        if (empty($prices)) {
            return '';
        }

        $min = min($prices);
        $max = max($prices);
        $range = $max - $min ?: 1;

        return collect($prices)->map(function($price, $index) use ($min, $range) {
            $x = $index * (100 / 23);
            $y = 30 - (($price - $min) / $range * 30);
            return "{$x},{$y}";
        })->join(' ');
    }

    public function getSparklinePoints($crypto)
    {
        if (!isset($crypto['sparkline_in_7d']['price']) || !is_array($crypto['sparkline_in_7d']['price'])) {
            return '';
        }

        return $this->calculateSparklinePoints($crypto['sparkline_in_7d']['price']);
    }

    public function render()
    {
        return view('livewire.crypto-table', [
            'cryptos' => $this->getCryptos(),
        ]);
    }
}
