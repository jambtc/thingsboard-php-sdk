<?php

namespace ThingsBoard\Http;

use Psr\Http\Message\ResponseInterface;

class Response
{
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    public function getBody()
    {
        return $this->response->getBody()->getContents();
    }

    public function getJson()
    {
        return json_decode($this->getBody(), true);
    }
}
