<?php

namespace Request;

class Request
{
    private string $method;
    private string $uri;
    private array $headers;
    protected array $body;

public function __construct(string $method, string $uri, array $headers =[], array $body=[] )
{
    $this->method=$method;
    $this->uri=$uri;
    $this->headers=$headers;
    $this->body=$body;

}

    public function getMethod()
    {
        return $this->method;
    }
    public function getUri()
    {
        return $this->uri;
    }
    public function getHeaders()
    {
        return $this->headers;
    }
    public function getBody()
    {
        return $this->body;
    }

}