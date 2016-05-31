<?php

namespace Vinci\Domain\Search;

use Elasticsearch\ClientBuilder;
use Illuminate\Contracts\Config\Repository;

class SearchService
{

    protected $builder;

    protected $config;

    protected $client;

    public function __construct(ClientBuilder $builder, Repository $config)
    {
        $this->builder = $builder;
        $this->config = $config;

        $this->buildClient();
    }

    public function getClient()
    {
        return $this->client;
    }

    protected function buildClient()
    {
        $client = $this->builder
            ->create()
            ->setHosts($this->getHosts())
            ->build();

        return $this->client = $client;
    }

    protected function getHosts()
    {
        $hostsConfig = $this->config->get('search.hosts');

        $hosts = [];

        foreach ($hostsConfig as $host) {
            $hosts[] = sprintf('%s:%s', $host['host'], $host['port']);
        }

        return $hosts;
    }

}