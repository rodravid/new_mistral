<?php

namespace Vinci\Domain\Product\Jobs;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Vinci\App\Core\Jobs\Job;
use Vinci\Domain\Search\Product\ProductIndexerService;

class SyncProductWithElasticsearch extends Job implements ShouldQueue
{

    use InteractsWithQueue, SerializesModels;

    protected $productId;

    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    public function handle(ProductIndexerService $productIndexer, EntityManagerInterface $entityManager)
    {
        try {

            $productIndexer->syncOne($this->productId);

            $entityManager->clear();

        } catch (Exception $e) {

            $this->delete();

            Log::error(sprintf('Error when indexing product #%s in elasticsearch', $this->productId));

        } finally {
            $entityManager->clear();
        }
    }
}