<?php

namespace ThingsBoard\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AuthService
{
    private Client $client;
    private string $baseUrl;
    private ?string $token = null;

    public function __construct(string $baseUrl)
    {
        $this->client = new Client();
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function authenticate(string $username, string $password): ?string
    {
        try {
            $response = $this->client->post($this->baseUrl . '/api/auth/login', [
                'json' => [
                    'username' => $username,
                    'password' => $password
                ]
            ]);
            $data = json_decode($response->getBody()->getContents(), true);
            $this->token = $data['token'] ?? null;

            return $this->token;
        } catch (RequestException $e) {
            // Gestire l'eccezione
            return null;
        }
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
