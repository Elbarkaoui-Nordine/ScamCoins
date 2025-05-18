<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Client\Response;

interface CoingekoApiServiceInterface
{
    /**
     * Get all crypto coins with market data
     *
     * @param array $params Optional parameters like vs_currency, order, per_page, page, etc.
     * @return Response
     */
    public function getCryptos(array $params = []): Response;

    /**
     * Search for crypto coins
     *
     * @param string $query The search query
     * @return Response
     */
    public function searchCrypto(string $query): Response;

    /**
     * Make a GET request to the Coingeko API
     *
     * @param string $endpoint
     * @param array $params
     * @return Response
     */
    public function get(string $endpoint, array $params = []): Response;

    /**
     * Make a POST request to the Coingeko API
     *
     * @param string $endpoint
     * @param array $data
     * @return Response
     */
    public function post(string $endpoint, array $data = []): Response;

    /**
     * Make a PUT request to the Coingeko API
     *
     * @param string $endpoint
     * @param array $data
     * @return Response
     */
    public function put(string $endpoint, array $data = []): Response;

    /**
     * Make a DELETE request to the Coingeko API
     *
     * @param string $endpoint
     * @return Response
     */
    public function delete(string $endpoint): Response;

    /**
     * Get trending coins, NFTs and categories
     *
     * @return Response
     */
    public function getTrending(): Response;

    public function getNfts(array $params = []): Response;
    public function getCryptoById(string $id): Response;
    public function getNftById(string $id): Response;   
} 