<?php

use PHPUnit\Framework\TestCase;
use ThingsBoard\Controllers\DeviceController;
use ThingsBoard\Auth\AuthService;

class DeviceControllerTest extends TestCase
{
    public function testGetDevices()
    {
        // Simula il servizio di autenticazione
        $authService = $this->createMock(AuthService::class);
        $authService->method('getToken')->willReturn('fake_token');
        $authService->method('getBaseUrl')->willReturn('https://thingsboard.example.com');

        // Simula una risposta dal client HTTP
        $client = $this->createMock(\ThingsBoard\Http\Client::class);
        $client->method('request')
               ->willReturn(new \ThingsBoard\Http\Response(['data' => ['device1', 'device2'], 'hasNext' => false]));

        // Instanzia il controller e testiamo la funzione getDevices
        $deviceController = new DeviceController($authService, $client);

        $devices = $deviceController->getDevices();

        // Asserisci che l'array dei dispositivi non sia vuoto
        $this->assertNotEmpty($devices);
        $this->assertEquals(2, count($devices));
    }
}
