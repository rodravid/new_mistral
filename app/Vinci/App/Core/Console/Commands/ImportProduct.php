<?php

namespace Vinci\App\Core\Console\Commands;

use Carbon\Carbon;
use Doctrine\ORM\EntityManager;
use Illuminate\Console\Command;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\Product\Services\ProductManagementService;

class ImportProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products {limit=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa os produtos da tabela bkp_produtos';

    private $em;
    /**
     * @var ProductManagementService
     */
    private $service;

    public function __construct(EntityManager $em, ProductManagementService $service)
    {
        parent::__construct();

        $this->em = $em;
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->create();
    }

    public function create()
    {
        $conn = $this->em->getConnection();

        $stmt = $conn->prepare('select * from bkp_produtos where imported=0 limit ' . $this->argument('limit'));
        $stmt->execute();

        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $total = count($products);
        $error = 0;

        if ($total) {
            $this->line('');
            $this->info("importing " . $total . " product(s).");
            $this->line('');

            $progressBar = $this->output->createProgressBar($total);
            foreach ($products as $product) {
                $data = [];
                $data["type"]["id"] = $product["cod_type"];
                $data["channels"][0] = "1";
                $data["sku"] = $product["sku"];
                $data["title"] = $this->normalizeValue($product["title"]);
                $data["shortDescription"] = null;
                $data["description"] = $this->normalizeValue($product["description"]);

                $data["slug"] = null;
                $data["seoTitle"] = "";
                $data["seoDescription"] = "";
                $data["seoKeywords"] = "";
                $data["price"][0]["channel"]["id"] = "1";
                $data["price"][0]["price"] = $this->normalizeValue($product["price"]);
                $data["price"][0]["currency_amount"] = null;
                $data["price"][0]["aliquot_ipi"] = $product["aliquot_ipi"];
                $data["price"][0]["discount_type"] = null;
                $data["price"][0]["discount_value"] = $this->normalizeValue($product["discount_amount"]);
                $data["should_import_price"] = 1;
                $data["stock"] = $product["stock"];
                $data["should_import_stock"] = 1;

                //vintage
                $data["attributes"][0]["attribute_id"] = 1;
                $data["attributes"][0]["value"] = $this->normalizeValue($product["vintage"]);

                //alcoholic_strength
                $data["attributes"][1]["attribute_id"] = 2;
                $data["attributes"][1]["value"] = $this->normalizeValue($product["alcoholic_strength"]);

                //temperature
                $data["attributes"][2]["attribute_id"] = 3;
                $data["attributes"][2]["value"] = $this->normalizeValue($product["temperature"]);

                //decantation
                $data["attributes"][3]["attribute_id"] = 4;
                $data["attributes"][3]["value"] = $this->normalizeValue($product["decantation"]);

                //vineyard
                $data["attributes"][4]["attribute_id"] = 5;
                $data["attributes"][4]["value"] = $this->normalizeValue($product["vineyard"]);

                //vinification
                $data["attributes"][5]["attribute_id"] = 6;
                $data["attributes"][5]["value"] = $this->normalizeValue($product["vinification"]);

                //blend
                $data["attributes"][6]["attribute_id"] = 7;
                $data["attributes"][6]["value"] = $this->normalizeValue($product["blend"]);

                //gastronomy_pairings
                $data["attributes"][7]["attribute_id"] = 8;
                $data["attributes"][7]["value"] = $this->normalizeValue($product["gastronomy_pairings"]);

                //maturation
                $data["attributes"][8]["attribute_id"] = 9;
                $data["attributes"][8]["value"] = $this->normalizeValue($product["maturation"]);

                $data["startsAt"] = Carbon::now()->format('d/m/Y H:i');
                $data["expirationAt"] = null;
                $data["status"] = "1";
                $data["image_desktop"] = null;
                $data["image_mobile"] = null;

                try {
                    $result = $this->service->create($data);
                    $stmt = $conn->prepare('update bkp_produtos set imported=1 where sku = ' . $product["sku"]);
                    $stmt->execute();

                } catch (ValidationException $e) {
                    $stmt = $conn->prepare('update bkp_produtos set imported=2 where sku = ' . $product["sku"]);
                    $stmt->execute();

                    $this->line('');
                    $this->error("Erro ao adicionar o produto [" . $product["sku"] . "]");
                    $this->info($e->getErrors()->first());
                    $this->line('');

                    $error++;

                } catch (\Exception $e) {
                    $stmt = $conn->prepare('update bkp_produtos set imported=2 where sku = ' . $product["sku"]);
                    $stmt->execute();

                    $this->line('');
                    $this->error("Erro ao adicionar o produto [" . $product["sku"] . "]");
                    $this->info($e->getMessage());
                    $this->line('');

                    $error++;

                }

                $progressBar->advance();

            }
            $progressBar->finish();
            $this->line("\n");
            $this->info($error . ' error');
            $this->info(($total-$error) . ' imported');
            $this->line('');

        }


    }

    public function normalizeValue($value)
    {
        if ($value == "NULL" || empty($value)) {
            return null;
        }

        return $value;
    }

}