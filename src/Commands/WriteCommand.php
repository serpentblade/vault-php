<?php

namespace VaultPhp\Commands;

use VaultPhp\Responses\WriteResponse;

class WriteCommand extends AbstractCommand
{
    /** @var string */
    protected $method = 'POST';

    protected $responseClass = WriteResponse::class;

    protected function setRequestParameters(array $parameters)
    {
        list($path, $data) = $parameters;


        $this->uriPath = '/'.ltrim($path, '/');

        if($data)
        {
            $this->body = $data;
        }
    }
}
