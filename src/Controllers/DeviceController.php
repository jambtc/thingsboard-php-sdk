<?php

namespace ThingsBoard\Controllers;

use ThingsBoard\Auth\AuthService;
use ThingsBoard\Http\Client;

/**
 * DeviceController class
 * 
 * This controller handles device-related operations such as fetching device information and time-series data keys.
 */
class DeviceController
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
     * Get Device Information
     *
     * Fetches information about a specific device using its device ID.
     *
     * @param string $deviceId The ID of the device to retrieve information for.
     * @return array|null Returns an array of device information if successful, or null if the request fails.
     */
    public function getDevice(string $deviceId): ?array
    {
        // Makes an HTTP GET request to fetch device information.
        $response = $this->client->request(
            $this->authService->getBaseUrl(),
            'GET',
            '/api/device/' . $deviceId,
            ['headers' => ['X-Authorization' => 'Bearer ' . $this->authService->getToken()]]
        );

        // Returns the JSON response as an associative array, or null if the request failed.
        return $response ? $response->getJson() : null;
    }

    /**
     * Recupera una singola pagina di dispositivi del tenant.
     * Effettua una richiesta all'API di ThingsBoard per ottenere i dispositivi paginati.
     *
     * @param int $pageSize Il numero di dispositivi da recuperare in una singola pagina. Valore predefinito: 10.
     * @param int $page Il numero della pagina da recuperare. Valore predefinito: 0 (prima pagina).
     * @return array|null Ritorna un array contenente i dispositivi della pagina corrente e i metadati della risposta
     *                    (come `totalPages`, `hasNext`, ecc.). Ritorna `null` in caso di errore.
     */

    public function getDevices(int $pageSize = 20, int $page = 0): ?array
    {
        // Makes an HTTP GET request to fetch all devices information.
        $response = $this->client->request(
            $this->authService->getBaseUrl(),
            'GET',
            '/api/tenant/devices',
            [
                'headers' => ['X-Authorization' => 'Bearer ' . $this->authService->getToken()],
                'query' => [
                    'pageSize' => $pageSize,
                    'page' => $page,
                ],
            ]
        );

        // Returns the JSON response as an associative array, or null if the request failed.
        return $response ? $response->getJson() : null;
    }

    /**
     * Recupera tutti i dispositivi del tenant utilizzando la paginazione.
     * Itera attraverso le pagine di dispositivi usando il campo `hasNext` della risposta API,
     * che indica se ci sono altre pagine disponibili.
     *
     * @param int $pageSize Il numero di dispositivi da recuperare per ogni richiesta (dimensione della pagina).
     *                      Valore predefinito: 10.
     * @return array Ritorna un array contenente tutti i dispositivi recuperati. Se non ci sono dispositivi o in caso
     *               di errore, ritorna un array vuoto.
     */
    public function getAllDevices(int $pageSize = 20): array
    {
        $allDevices = [];
        $page = 0;
        $hasNext = true;

        while ($hasNext) {
            $response = $this->getDevices($pageSize, $page);

            if ($response && isset($response['data'])) {
                // Unisci i dispositivi della pagina corrente all'array totale
                $allDevices = array_merge($allDevices, $response['data']);

                // Controlla se c'è una pagina successiva tramite 'hasNext'
                $hasNext = $response['hasNext'] ?? false;
                $page++; // Incrementa il numero della pagina per la prossima richiesta
            } else {
                $hasNext = false; // Interrompi se non c'è risposta valida
            }
        }

        return $allDevices;
    }

    /**
     * Fetch List of All Time-Series Data Keys
     *
     * Retrieves a list of all time-series data keys for a specific device.
     *
     * @param string $deviceId The ID of the device to retrieve time-series data keys for.
     * @return array|null Returns an array of time-series data keys if successful, or null if the request fails.
     */
    public function getTelemetryKeys(string $deviceId): ?array
    {
        // Makes an HTTP GET request to fetch time-series data keys for the device.
        $response = $this->client->request(
            $this->authService->getBaseUrl(),
            'GET',
            '/api/plugins/telemetry/DEVICE/' . $deviceId . '/keys/timeseries',
            ['headers' => ['X-Authorization' => 'Bearer ' . $this->authService->getToken()]]
        );

        // Returns the JSON response as an associative array, or null if the request failed.
        return $response ? $response->getJson() : null;
    }


    /**
     * Ottiene i valori della telemetria per un dispositivo specifico.
     *
     * @param string $deviceId L'ID del dispositivo per il quale si vogliono ottenere i valori della telemetria.
     * @param array $keys Un array di chiavi di telemetria per cui si desiderano i valori.
     * @return array|null Restituisce i dati di telemetria come array associativo, o null se la richiesta fallisce.
     */
    public function getTelemetryValues(string $deviceId, array $keys): ?array
    {
        // Converte l'array di chiavi in una stringa separata da virgole
        $keysString = implode(',', $keys);

        // Effettua una richiesta HTTP GET per ottenere i dati di telemetria per il dispositivo specificato
        $response = $this->client->request(
            $this->authService->getBaseUrl(),
            'GET',
            '/api/plugins/telemetry/DEVICE/' . $deviceId . '/values/timeseries?keys=' . urlencode($keysString),
            ['headers' => ['X-Authorization' => 'Bearer ' . $this->authService->getToken()]]
        );

        // Restituisce la risposta JSON come array associativo, o null se la richiesta è fallita
        return $response ? $response->getJson() : null;
    }

    /**
     * Create Device
     *
     * Creates a new device in ThingsBoard using the provided device details.
     *
     * @param array $deviceData The data of the device to create (e.g., name, type, etc.).
     * @return array|null Returns an array of the created device information if successful, or null if the request fails.
     */
    public function createDevice(array $deviceData): ?array
    {
        // Makes an HTTP POST request to create a new device.
        $response = $this->client->request(
            $this->authService->getBaseUrl(),
            'POST',
            '/api/device',
            [
                'headers' => [
                    'X-Authorization' => 'Bearer ' . $this->authService->getToken(),
                    'Content-Type' => 'application/json'
                ],
                'json' => $deviceData
            ]
        );

        // Returns the JSON response as an associative array, or null if the request failed.
        return $response ? $response->getJson() : null;
    }


    // Other controller methods can be added here
}
