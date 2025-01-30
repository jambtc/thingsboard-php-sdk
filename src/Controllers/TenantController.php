<?php

namespace ThingsBoard\Controllers;

use ThingsBoard\Auth\AuthService;
use ThingsBoard\Http\Client;

/**
 * TenantController class
 * 
 * This controller handles thingsboard Tenants
 */
class TenantController
{
    private AuthService $authService;
    private Client $client;

    /**
     * Constructor method
     *
     * Initializes the DeviceController with AuthService and creates a new HTTP client instance.
     *
     * @param AuthService $authService The authentication service to handle authorization.
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->client = new Client();
    }

    /**
     * Fetches information about default Tenant Profile.
     *
     * @return array|null Returns an array of tenant profile information if successful, or null if the request fails.
     */
    public function getDefaultProfile(): ?array
    {
        // Makes an HTTP GET request to fetch tenant profile information.
        $response = $this->client->request(
            $this->authService->getBaseUrl(),
            'GET',
            '/api/tenantProfileInfo/default',
            [
                'headers' => [
                    'X-Authorization' => 'Bearer ' . $this->authService->getToken(),
                    'Content-Type' => 'application/json',
                ]
            ]
        );

        // Returns the JSON response as an associative array, or null if the request failed.
        return $response ? $response->getJson() : null;
    }

    /**
     * Create New Tenant
     * 
     * @return array|null Returns new tenant information if successful, or null if the request fails.
     */
    public function createTenant(array $tenantData): ?array
    {
        // Makes an HTTP GET request to fetch tenant profile information.
        $response = $this->client->request(
            $this->authService->getBaseUrl(),
            'POST',
            '/api/tenant',
            [
                'headers' => [
                    'X-Authorization' => 'Bearer ' . $this->authService->getToken(),
                    'Content-Type' => 'application/json'
                ],
                'json' => $tenantData
            ]
        );

        // Returns the JSON response as an associative array, or null if the request failed.
        return $response ? $response->getJson() : null;
    }

    /**
     * Delete Tenant
     * 
     * @param $tenantId 
     * @return array|null Returns boolean, or null if the request fails.
     */
    public function deleteTenant(string $tenantId): ?array
    {
        $response = $this->client->request(
            $this->authService->getBaseUrl(),
            'DELETE',
            '/api/tenant/' . $tenantId,
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
