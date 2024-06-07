<?php

namespace ThingsBoard\Controllers;

use ThingsBoard\Http\Client;

class DeviceController
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getDevice($deviceId)
    {
        return $this->client->request('GET', '/api/device/' . $deviceId)->getJson();
    }

    public function getDevices($limit = 100)
    {
        return $this->client->request('GET', '/api/tenant/devices?limit=' . $limit)->getJson();
    }

    public function createDevice($name, $type)
    {
        $body = [
            'name' => $name,
            'type' => $type
        ];

        return $this->client->request('POST', '/api/device', ['json' => $body])->getJson();
    }
}
