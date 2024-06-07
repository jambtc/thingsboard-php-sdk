<?php

namespace ThingsBoard\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

class Client
{
    private GuzzleClient $client;

    public function __construct()
    {
        $this->client = new GuzzleClient();
    }

    public function request(string $baseUrl, string $method, string $uri, array $options = []): ?Response
    {
        $client = new GuzzleClient(['base_uri' => $baseUrl]);

        try {
            $response = $client->request($method, $uri, $options);
            return new Response($response);
        } catch (RequestException $e) {
            // Gestire l'eccezione
            return null;
        }
    }
}
