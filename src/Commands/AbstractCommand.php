<?php

namespace VaultPhp\Commands;

use GuzzleHttp\Psr7\Response;

use VaultPhp\Client;
use VaultPhp\Responses\AbstractResponse;

abstract class AbstractCommand
{
    /** @var Client */
    protected $client;

    /** @var AbstractResponse */
    protected $responseClass;

    /** @var string */
    protected $uriPath;

    /** @var string */
    protected $method = 'GET';

    /** @var any */
    protected $body;

    public function __construct(Client $client, array $parameters)
    {
        $this->client = $client;
        $this->setRequestParameters($parameters);
    }

    public function getClient()
    {
        return $this->client;
    }

    protected abstract function setRequestParameters(array $parameters);

    /**
        Run Command

        @return AbstractResponse
    */
    public function run()
    {
        $params = [];

        if($this->body)
        {
            $params['json'] = $this->body;
        }

        $data = $this->client->request($this->method, $this->uriPath, $params);

        return $this->makeResponse($data);
    }

    protected function makeResponse(Response $response)
    {
        return new $this->responseClass($this, $response);
    }
}
