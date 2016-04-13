<?php

namespace VaultPhp;

use GuzzleHttp\Client as GuzzleClient;

class Client
{
    /** @var string */
    protected $endpoint;

    /** @var GuzzleClient */
    protected $guzzleClient;

    /** @var string */
    protected $apiVersion;

    /** @var string */
    protected $token;

    public function __construct(array $config)
    {
        $this->setConfig($config);
    }

    public function setConfig(array $config)
    {
        $this->apiVersion = isset($config['version']) ? $config['version'] : '1';
        $this->endpoint = isset($config['endpoint']) ? $config['endpoint'] : 'https://localhost:8200';

        $this->token = isset($config['token']) ? $config['token'] : null;

        $this->guzzleClient = new GuzzleClient([
           'base_uri' => $this->endpoint,
           'timeout' => isset($config['timeout']) ? $config['timeout'] : 30.0,
           'headers' => [
                'X-Vault-Token' => $this->token
           ]
        ]);
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function getGuzzleClient()
    {
        return $this->guzzleClient;
    }

    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    protected function makeUri($uriPath)
    {
        return '/v'.$this->apiVersion.'/'.ltrim($uriPath, '/');
    }

    public function request($method, $uriPath, array $params = null)
    {
        return $this->guzzleClient->request($method, $this->makeUri($uriPath), $params);
    }

    public function __call($method, $parameters)
    {
        $class = 'VaultPhp\\Commands\\'.ucwords($method).'Command';
        $command = new $class($this, $parameters);
        return $command->run();
    }
}
