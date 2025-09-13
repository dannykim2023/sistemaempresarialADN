<?php
namespace App\Services;

use GuzzleHttp\Client;

class ApiDniService
{
    protected $client;
    protected $token;

    public function __construct()
    {
        $this->token = env('DECOLECTA_TOKEN'); // 👈 agrega tu token en .env
        $this->client = new Client([
            'base_uri' => 'https://api.decolecta.com/v1/',
            'verify' => false,
        ]);
    }

    public function consultarDni(string $dni): ?array
    {
        try {
            $response = $this->client->get("reniec/dni", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'Accept'        => 'application/json',
                ],
                'query' => [
                    'numero' => $dni,
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                return null;
            }

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return null;
        }
    }
}
