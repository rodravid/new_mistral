<?php
namespace Vinci\App\Website\Http\Import;

use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Product\Services\ProductManagementService;

class ImportController extends Controller
{
    /**
     * @var ProductService
     */
    private $service;

    public function __construct(EntityManagerInterface $em, ProductManagementService $service)
    {
        parent::__construct($em);
        $this->service = $service;
    }

    public function create()
    {
        $conn = $this->entityManager->getConnection();

        $stmt = $conn->prepare('select * from bkp_produtos where imported=0 limit 10');
        $stmt->execute();

        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
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

                echo $product["sku"] . " - importado com sucesso<hr>";

            } catch (ValidationException $e){

                dd($e->getErrors()->all());

            } catch (\Exception $e) {
                $stmt = $conn->prepare('update bkp_produtos set imported=2 where sku = ' . $product["sku"]);
                $stmt->execute();
                throw $e;
            }

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