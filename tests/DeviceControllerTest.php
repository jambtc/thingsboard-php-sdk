<?php

use PHPUnit\Framework\TestCase;
use ThingsBoard\Controllers\DeviceController;
use ThingsBoard\Auth\AuthService;
use GuzzleHttp\Psr7\Response;

class DeviceControllerTest extends TestCase
{
    public function testGetDevices()
    {
        // Simula il servizio di autenticazione
        $authService = $this->createMock(AuthService::class);
        $authService->method('getToken')->willReturn('fake_token');
        $authService->method('getBaseUrl')->willReturn('https://thingsboard.example.com');

        // Crea un mock della risposta PSR-7
        $mockResponse = new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(['data' => ['device1', 'device2'], 'hasNext' => false])
        );

        // Simula il client HTTP per restituire la risposta fittizia
        $client = $this->createMock(\ThingsBoard\Http\Client::class);
        $client->method('request')
            ->willReturn($mockResponse); // Usa la risposta fittizia come ritorno della chiamata

        // Instanzia il controller e testiamo la funzione getDevices
        $deviceController = new DeviceController($authService, $client);

        $devices = $deviceController->getDevices();

        // Asserisci che l'array dei dispositivi non sia vuoto
        $this->assertNotEmpty($devices);
        $this->assertEquals(2, count($devices));
    }
}
