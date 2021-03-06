<?php

namespace Vinci\App\Integration\ERP\Console\Commands;

use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Mail;
use Vinci\App\Integration\ERP\Product\ProductImporter;
use Vinci\Domain\ERP\Product\ProductService;
use Vinci\Domain\Product\Repositories\ProductRepository;

class ImportProducts extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:integration:products:import 
                            {products?* : IDs array of products}
                            {--all : Import all products from ERP}
                            {--new : Import only new products from ERP}
                            {--changed : Import only changed products from ERP}
                            {--send-log-mail-to=}
                            {--exceptions : Throws exceptions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from ERP.';

    protected $productImporter;

    protected $productService;

    public function __construct(ProductImporter $productImporter, ProductService $productService)
    {
        parent::__construct();

        $this->productImporter = $productImporter;
        $this->productService = $productService;
    }

    public function handle()
    {
        $productsSKU = $this->getProductsSKU();

        $start = Carbon::now();

        $this->info(sprintf('Started in: %s', $start->format('d/m/Y H:i:s')));

        if ($productsSKU->count()) {

            if ($productsSKU->count() == 1) {
               $this->importOne($productsSKU->first(), false, $this->option('exceptions'));

            } else {
               $this->importMany($productsSKU);
            }

            if (! empty($email = $this->option('send-log-mail-to'))) {
                Mail::raw('Segue em anexo o log de erros de integração de produtos.', function($message) use ($email) {
                    $message->subject('Log de erros de integração de produtos');
                    $message->to($email);
                    $message->attach(storage_path('/app/products_integration_errors.txt'), ['as' => 'products_integration_logs.txt', 'mime' => 'text/plain']);
                });
            }

        } else {
            $this->info('Nothing to do.');
        }

        $end = Carbon::now();
        $this->info(sprintf('Completed in: %s', $end->format('d/m/Y H:i:s')));
        $this->info(sprintf('Total time: %s seconds', $start->diffInSeconds($end)));
    }

    public function importOne($productSKU, $silent = false, $exceptions = false)
    {
        if (! $silent) {
            $this->info(sprintf('Importing product #%s from ERP...', $productSKU));
        }

        try {

            $this->productImporter->importOneBySKU($productSKU);

            if (! $silent) {
                $this->info('Done!');
            }

        } catch (Exception $e) {

            if ($exceptions) {
                throw $e;
            }

            if (! $silent) {
                $this->error($e->getMessage());
            }

        }
    }

    public function importMany($productsSKU)
    {
        $progressBar = $this->output->createProgressBar($productsSKU->count());

        $this->info(sprintf('Importing %s products from ERP...', $productsSKU->count()));
        $success = [];
        $error = [];

        foreach ($productsSKU as $productSKU) {

            try {

                $this->importOne($productSKU, true);

                $success[] = $productSKU;

            } catch (Exception $e) {
                $error[] = $productSKU;
            }

            $progressBar->advance();
        }

        $progressBar->finish();

        $this->info("\n");

        if (! empty($success)) {
            $this->info(sprintf("\n%s products imported with success!", count($success)));
        }

        if (! empty($error)) {
            $this->error(sprintf("\n%s products were not imported!", count($error)));
        }
    }

    public function getProductsSKU()
    {
        $productsInput = collect($this->argument('products'));

        if ($productsInput->count()) {
            return $productsInput;
        }

        $products = collect();

        if ($this->option('all')) {
            $all = $this->productService->getAllProducts();
            $this->appendToCollection($products, $all);

            $localProducts = app(ProductRepository::class)->getAllProductsSku();

            $this->appendToCollection($products, $localProducts);
        }

        if ($this->option('new')) {
            $new = $this->productService->getNewProducts();
            $this->appendToCollection($products, $new);
        }

        if ($this->option('changed')) {
            $changed = $this->productService->getChangedProducts();
            $this->appendToCollection($products, $changed);
        }

        return $products;
    }

    protected function appendToCollection(Collection $collection, $values)
    {
        foreach ($values as $value) {
            if (! $collection->contains($value)) {
                $collection->push($value);
            }
        }
    }

}