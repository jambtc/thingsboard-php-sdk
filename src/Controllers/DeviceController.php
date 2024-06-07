<?php

namespace ThingsBoard\Controllers;

use ThingsBoard\Auth\AuthService;
use ThingsBoard\Http\Client;

class DeviceController
{
    private AuthService $authService;
    private Client $client;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->client = new Client();
    }

    public function getDevice(string $deviceId): ?array
    {
        $response = $this->client->request(
            $this->authService->getBaseUrl(),
            'GET',
            '/api/device/' . $deviceId,
            ['headers' => ['X-Authorization' => 'Bearer ' . $this->authService->getToken()]]
        );

        return $response ? $response->getJson() : null;
    }

    // Altri metodi del controller
}
