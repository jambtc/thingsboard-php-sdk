<?php

namespace ThingsBoard\Controllers;

use ThingsBoard\Auth\AuthService;
use ThingsBoard\Http\Client;

/**
 * UserController class
 * 
 * This controller handles thingsboard Users
 */
class UserController
{
    private AuthService $authService;
    private Client $client;

    /**
     * Constructor method
     *
     * Initializes the UserController with AuthService and creates a new HTTP client instance.
     *
     * @param AuthService $authService The authentication service to handle authorization.
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->client = new Client();
    }


    /**
     * Get User Information
     *
     * Fetches information about a specific user using its user ID.
     *
     * @param string $userId The ID of the user to retrieve information for.
     * @return array|null Returns an array of user information if successful, or null if the request fails.
     */
    public function getUser(string $userId): ?array
    {
        // Makes an HTTP GET request to fetch user information.
        $response = $this->client->request(
            $this->authService->getBaseUrl(),
            'GET',
            '/api/user/' . $userId,
            ['headers' => ['X-Authorization' => 'Bearer ' . $this->authService->getToken()]]
        );

        // Returns the JSON response as an associative array, or null if the request failed.
        return $response ? $response->getJson() : null;
    }



    /**
     * Get User Activation Link 
     *
     * Fetches information about a specific user using its user ID.
     *
     * @param string $userId The ID of the user to retrieve information for.
     * @return array|null Returns an array of user information if successful, or null if the request fails.
     */
    public function getUserActivationLink(string $userId): ?array
    {
        // Makes an HTTP GET request to fetch user information.
        $response = $this->client->request(
            $this->authService->getBaseUrl(),
            'GET',
            '/api/user/' . $userId . '/activationLinkInfo',
            ['headers' => ['X-Authorization' => 'Bearer ' . $this->authService->getToken()]]
        );

        // Returns the JSON response as an associative array, or null if the request failed.
        return $response ? $response->getJson() : null;
    }


    /**
     * Create New User
     * 
     * @return array|null Returns new user information if successful, or null if the request fails.
     */
    public function createUser(array $userData): ?array
    {
        $response = $this->client->request(
            $this->authService->getBaseUrl(),
            'POST',
            '/api/user?sendActivationMail=false',
            [
                'headers' => [
                    'X-Authorization' => 'Bearer ' . $this->authService->getToken(),
                    'Content-Type' => 'application/json'
                ],
                'json' => $userData
            ]
        );

        // Returns the JSON response as an associative array, or null if the request failed.
        return $response ? $response->getJson() : null;
    }

    /**
     * Activate Account
     * 
     * @return array|null Returns successfull, or null if the request fails.
     */
    public function activateAccount(array $userData): ?array
    {
        $response = $this->client->request(
            $this->authService->getBaseUrl(),
            'POST',
            '/api/noauth/activate?sendActivationMail=false',
            [
                'headers' => [
                    'X-Authorization' => 'Bearer ' . $this->authService->getToken(),
                    'Content-Type' => 'application/json'
                ],
                'json' => $userData
            ]
        );

        // Returns the JSON response as an associative array, or null if the request failed.
        return $response ? $response->getJson() : null;
    }

    /**
     * Delete User
     * 
     * @return array|null Returns boolean, or null if the request fails.
     */
    public function deleteUser(string $userId): ?array
    {
        $response = $this->client->request(
            $this->authService->getBaseUrl(),
            'DELETE',
            '/api/user/' . $userId,
            [
                'headers' => [
                    'X-Authorization' => 'Bearer ' . $this->authService->getToken(),
                    'Content-Type' => 'application/json'
                ],
            ]
        );

        // Returns the JSON response as an associative array, or null if the request failed.
        return $response ? $response->getJson() : null;
    }




    // Other controller methods can be added here
}
