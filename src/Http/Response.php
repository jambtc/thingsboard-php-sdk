<?php

namespace ThingsBoard\Http;

use Psr\Http\Message\ResponseInterface;

class Response
{
    private ?ResponseInterface $response;
    private ?string $error;

    public function __construct(?ResponseInterface $response, ?string $error = null)
    {
        $this->response = $response;
        $this->error = $error;
    }

    public function getStatusCode(): ?int
    {
        return $this->response ? $this->response->getStatusCode() : null;
    }

    public function getBody(): ?string
    {
        return $this->response ? $this->response->getBody()->getContents() : $this->error;
    }

    public function getJson(): ?array
    {
        return $this->response ? json_decode($this->getBody(), true) : null;
    }

    public function getError(): ?string
    {
        return $this->error;
    }
}
