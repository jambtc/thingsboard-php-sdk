<?php

namespace ThingsBoard\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use ThingsBoard\Auth\AuthService;

class Client
{
    private $authService;
    private $client;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->client = new GuzzleClient();
    }

    public function request($method, $uri, $options = [])
    {
        $options['headers']['X-Authorization'] = 'Bearer ' . $this->authService->getToken();
        $options['headers']['Content-Type'] = 'application/json';

        try {
            $response = $this->client->request($method, $this->authService->getBaseUrl() . $uri, $options);
            return new Response($response);
        } catch (RequestException $e) {
            // Gestire l'eccezione
            return null;
        }
    }
}
