<?php

namespace Vinci\Domain\Search;

use Elasticsearch\ClientBuilder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Pagination\LengthAwarePaginator;
use Vinci\App\Website\Http\Presenters\DefaultPaginatorPresenter;
use Vinci\Domain\Search\Filter\FilterFactory;
use Vinci\Domain\Search\Result\SearchResult;
use Vinci\Domain\Search\Suggester\SuggesterFactory;

class SearchService
{

    protected $builder;

    protected $config;

    protected $client;

    protected $filterFactory;

    protected $suggesterFactory;

    public function __construct(
        ClientBuilder $builder,
        Repository $config,
        FilterFactory $filterFactory,
        SuggesterFactory $suggesterFactory
    ) {
        $this->builder = $builder;
        $this->config = $config;
        $this->filterFactory = $filterFactory;
        $this->suggesterFactory = $suggesterFactory;

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

    protected function parseResult(array $result)
    {

        $hits = $result['hits'];

        $searchResult = $this->getNewResultClassInstance();

        $searchResult->setTerm($result['keyword']);

        $searchResult->setSort($result['sort']);

        $searchResult->setLimit($result['limit']);
        
        $searchResult->setStart($result['start']);

        $searchResult->setTotal($hits['total']);

        $filters = $this->filterFactory->makeCollection(array_get($result, 'aggregations'));

        $searchResult->setFilters($filters);
        
        if (isset($result['suggest'])) {
            $suggesters = $this->suggesterFactory->makeCollection(array_get($result, 'suggest'));

            $searchResult->setSuggesters($suggesters);
        }

        if ($hits['total'] > 0) {

            $items = $this->parseItems($result);

            $paginator = $this->makePaginator($items, $result);

            $searchResult->setItems($paginator);
        }

        return $searchResult;
    }

    protected function parseItems(array $result)
    {
        return $result['hits']['hits'];
    }

    protected function getNewResultClassInstance()
    {
        return new SearchResult;
    }

    protected function makePaginator($items, $result)
    {
        $paginator = new LengthAwarePaginator($items, array_get($result, 'hits.total'), array_get($result, 'limit'));

        $paginator = new DefaultPaginatorPresenter($paginator);

        return $paginator;
    }

}