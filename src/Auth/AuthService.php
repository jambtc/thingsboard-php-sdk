<?php

namespace ThingsBoard\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use ThingsBoard\Http\Response;

class AuthService
{
    private $client;
    private $baseUrl;
    private $token;

    public function __construct($baseUrl)
    {
        $this->client = new Client();
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function authenticate($username, $password)
    {
        try {
            $response = $this->client->post($this->baseUrl . '/api/auth/login', [
                'json' => [
                    'username' => $username,
                    'password' => $password
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $this->token = $data['token'];

            return $this->token;
        } catch (RequestException $e) {
            // Gestire l'eccezione
            return null;
        }
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
}
