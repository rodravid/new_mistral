<?php

namespace Vinci\Domain\Search\Indexing;

use Elasticsearch\Client;
use Exception;
use Vinci\Domain\Search\Product\Indexing\IndexManager;

class IndexingService
{

    protected $client;

    protected $indexManager;

    protected $index;

    public function __construct(Client $client, IndexManager $indexManager)
    {
        $this->client = $client;
        $this->indexManager = $indexManager;
    }

    public function setIndex(Index $index)
    {
        $this->index = $index;
    }

    public function getIndex()
    {
        if ($this->index != null) {
            return $this->index;
        }

        if (property_exists($this, 'defaultIndex')) {
            return $this->index = new $this->defaultIndex;
        }

        throw new Exception('No index was defined!');
    }

    public function createIndex()
    {
        $index = $this->getIndex();

        if ($this->indexManager->exists($index)) {
            $this->indexManager->destroy($index);
        }

        return $this->indexManager->create($index);
    }

}