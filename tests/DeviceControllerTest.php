<?php

use PHPUnit\Framework\TestCase;
use ThingsBoard\Controllers\DeviceController;
use ThingsBoard\Auth\AuthService;
use ThingsBoard\Http\Client;
use ThingsBoard\Http\Response as ThingsBoardResponse;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class DeviceControllerTest extends TestCase
{
    public function testGetDevices()
    {
        // Simula il servizio di autenticazione
        $authService = $this->createMock(AuthService::class);
        $authService->method('getToken')->willReturn('fake_token');
        $authService->method('getBaseUrl')->willReturn('https://thingsboard.example.com');

        // Crea una risposta PSR-7 mockata per simulare una risposta dall'API
        $mockPsrResponse = new GuzzleResponse(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(['data' => ['device1', 'device2'], 'hasNext' => false])
        );

        // Simula una risposta di ThingsBoard
        $mockThingsBoardResponse = $this->createMock(ThingsBoardResponse::class);
        $mockThingsBoardResponse->method('getJson')->willReturn([
            'data' => ['device1', 'device2'],
            'hasNext' => false
        ]);

        // Simula il client HTTP per restituire la risposta fittizia di ThingsBoard
        $client = $this->createMock(Client::class);
        $client->method('request')
            ->willReturn($mockThingsBoardResponse); // Restituisce la risposta di ThingsBoard

        // Instanzia il controller e testiamo la funzione getDevices
        $deviceController = new DeviceController($authService, $client);

        $devices = $deviceController->getDevices();

        // Asserisci che l'array dei dispositivi non sia vuoto
        $this->assertNotEmpty($devices);
        $this->assertEquals(2, count($devices));
    }
}
