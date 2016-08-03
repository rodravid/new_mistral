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

    protected function makePaginator($items, $result)
    {
        $paginator = new LengthAwarePaginator($items, array_get($result, 'hits.total'), array_get($result, 'limit'));

        $paginator = new DefaultPaginatorPresenter($paginator);

        return $paginator;
    }

    protected function makeAggFilter($aggName, array $filters)
    {
        $mapping = $this->getAggMapping($aggName);
        $filter = [];

        if (isset($mapping['filtered_by'])) {

            foreach ($mapping['filtered_by'] as $agg) {

                $map = $this->getAggMapping($agg);

                if (!empty($values = array_get($filters, $agg))) {

                    if ($map['type'] == 'term') {
                        $filter['bool']['must'][]['terms'] = [$map['field'] => $values];

                    } elseif ($map['type'] == 'range') {
                        $filter['bool']['must'][]['range'] = [$map['field'] => $this->parseRangeValue($values[0])];
                    }
                }
            }
        }

        if (empty($filter)) {
            $filter = ['match_all' => []];
        }

        return $filter;
    }

    protected function getAggMapping($name)
    {
        return $this->aggsMapping[$name];
    }

    protected function addFilter(array &$params, $column, array $values)
    {
        $search = [
            'body' => [
                'filter' => [
                    'bool' => [
                        'must' => [
                            ['terms' => [$column => $values]],
                        ]
                    ]
                ]
            ]
        ];

        $params = array_merge_recursive($params, $search);
    }

    protected function parseRangeValue($value)
    {
        $range = explode('-', $value);

        $val = [];

        if ($range[0] !== '*') {
            $val['gte'] = $range[0];
        }

        if ($range[1] !== '*') {
            $val['lte'] = $range[1];
        }

        return $val;
    }

    protected function addFilterRange(array &$params, $column, array $values)
    {
        $search = [
            'body' => [
                'filter' => [
                    'bool' => [
                        'must' => [
                            ['range' => [$column => $this->parseRangeValue($values[0])]]
                        ]
                    ]
                ]
            ]
        ];

        $params = array_merge_recursive($params, $search);
    }

    protected function getFiltersTitles()
    {
        $titles = [];

        foreach ($this->aggsMapping as $key => $mapping) {
            $titles[$key] = array_get($mapping, 'title');
        }

        return $titles;
    }

    protected function getNewResultClassInstance()
    {
        if (property_exists($this, 'resultClass')) {
            return new $this->resultClass;
        }

        return new SearchResult;
    }

}