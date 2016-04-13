<?php

namespace VaultPhp\Responses;

use GuzzleHttp\Psr7\Response;

use VaultPhp\Client;
use VaultPhp\Commands\AbstractCommand;

abstract class AbstractResponse
{
    /** @var AbstractCommand */
    protected $command;

    /** @var Response */
    protected $response;

    /** @var array */
    protected $jsonBody;

    public function __construct(AbstractCommand $command, Response $response)
    {
        $this->command = $command;
        $this->response = $response;
        $this->parseResponse();
        $this->processResponse();
    }

    public function getStatus()
    {
        return $this->response->getStatusCode();
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function getWarnings()
    {
        return $this->jsonBody['warnings'];
    }

    private function parseResponse()
    {
        if($body = $this->response->getBody())
        {
            $this->jsonBody = json_decode($body, true);
        }
    }

    protected function processResponse() {}
}
