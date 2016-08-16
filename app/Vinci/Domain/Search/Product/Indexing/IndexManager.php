<?php

namespace Vinci\Domain\Search\Product\Indexing;

use Elasticsearch\Client as ElasticSearchClient;
use Vinci\Domain\Search\Indexing\Index;

class IndexManager
{

    protected $client;

    public function __construct(ElasticSearchClient $client)
    {
        $this->client = $client;
    }

    public function exists($index)
    {
        return $this->client->indices()->exists(['index' => $this->normalizeIndexName($index)]);
    }

    public function create(Index $index)
    {
        return $this->client->indices()->create($index->getDefinition());
    }

    public function destroy($index)
    {
        return $this->client->indices()->delete(['index' => $this->normalizeIndexName($index)]);
    }

    private function normalizeIndexName($index)
    {
        if ($index instanceof Index) {
            return $index->getName();
        }

        return $index;
    }

}