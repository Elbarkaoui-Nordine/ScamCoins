<?php

namespace App\Services;

use App\Services\Interfaces\CoingekoApiServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;

class CoingekoApiService implements CoingekoApiServiceInterface
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.coingeko.base_url');
        $this->apiKey = config('services.coingeko.api_key');
    }

    /**
     * Get all crypto coins with market data
     *
     * @param array $params Optional parameters like vs_currency, order, per_page, page, etc.
     * @return Response
     */
    public function getCryptos(array $params = []): Response
    {
        $defaultParams = [
            'vs_currency' => 'usd',
            'order' => 'market_cap_desc',
            'per_page' => 100,
            'page' => 1,
            'sparkline' => 'true',
            'price_change_percentage' => '24h'
        ];

        $params = array_merge($defaultParams, $params);

        return $this->get('/coins/markets', $params);
    }

    public function getNfts(array $params = []): Response
    {
        $defaultParams = [
            'per_page' => 20,
            'page' => 1,
        ];

        $params = array_merge($defaultParams, $params);

        return $this->get('/nfts/list', $params);
    }

    public function getCryptoById(string $id): Response
    {
        return $this->get("/coins/{$id}", [
            'localization' => false,
            'tickers' => false,
            'market_data' => true,
            'community_data' => false,
            'developer_data' => false,
            'sparkline' => false
        ]);
    }

    /**
     * Make a GET request to the Coingeko API
     *
     * @param string $endpoint
     * @param array $params
     * @return Response
     */
    public function get(string $endpoint, array $params = []): Response
    {
        try {
            return Http::withHeaders([
                'x-cg-demo-api-key' => $this->apiKey,
                'Accept' => 'application/json',
            ])->get($this->baseUrl . $endpoint, $params);
        } catch (\Exception $e) {
            Log::error('Coingeko API GET request failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Make a POST request to the Coingeko API
     *
     * @param string $endpoint
     * @param array $data
     * @return Response
     */
    public function post(string $endpoint, array $data = []): Response
    {
        try {
            return Http::withHeaders([
                'x-cg-demo-api-key' => $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . $endpoint, $data);
        } catch (\Exception $e) {
            Log::error('Coingeko API POST request failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Make a PUT request to the Coingeko API
     *
     * @param string $endpoint
     * @param array $data
     * @return Response
     */
    public function put(string $endpoint, array $data = []): Response
    {
        try {
            return Http::withHeaders([
                'x-cg-demo-api-key' => $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->put($this->baseUrl . $endpoint, $data);
        } catch (\Exception $e) {
            Log::error('Coingeko API PUT request failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Make a DELETE request to the Coingeko API
     *
     * @param string $endpoint
     * @return Response
     */
    public function delete(string $endpoint): Response
    {
        try {
            return Http::withHeaders([
                'x-cg-demo-api-key' => $this->apiKey,
                'Accept' => 'application/json',
            ])->delete($this->baseUrl . $endpoint);
        } catch (\Exception $e) {
            Log::error('Coingeko API DELETE request failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Search for a crypto coin
     *
     * @param string $query
     * @return Response
     */
    public function searchCrypto(string $query): Response
    {
        return Http::get("{$this->baseUrl}/search", [
            'query' => $query
        ]);
    }

    public function getTrending(): Response
    {
        return $this->get('/search/trending');
    }
} 