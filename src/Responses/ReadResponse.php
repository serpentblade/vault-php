<?php

namespace VaultPhp\Responses;

use GuzzleHttp\Psr7\Response;

use VaultPhp\Client;

class ReadResponse extends AbstractResponse
{
    public function getLeaseId()
    {
        return $this->jsonBody['lease_id'];
    }

    public function getLeaseDuration()
    {
        return $this->jsonBody['leaseDuration'];
    }

    public function getRenewable()
    {
        return $this->jsonBody['renewable'];
    }

    public function getData($key = null, $default = null)
    {
        $data = $this->jsonBody['data'];

        if(!$key)
        {
            return $data;
        }

        return isset($data[$key]) ? $data[$key] : $default;
    }
}
