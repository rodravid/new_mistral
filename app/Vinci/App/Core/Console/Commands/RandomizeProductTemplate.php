<?php

namespace Vinci\App\Core\Console\Commands;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Template\Template;

class RandomizeProductTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:randomize-template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Randomize Product Templates';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $productRepository = $this->em->getRepository(Product::class);

        $queryBuilder = $productRepository->createQueryBuilder('product');

        $query = $queryBuilder->getQuery();

        $iterator = $query->iterate();

        foreach ($iterator as $row) {
            $product = $row[0];

            $product->setTemplate($this->em->getReference(Template::class, rand(1, 8)));

            $this->em->persist($product);

            $this->em->flush();
        }
    }

}