<?php

namespace Vinci\Infrastructure\ERP\Product;

use Exception;
use Illuminate\Contracts\Config\Repository;
use Vinci\App\Integration\Exceptions\IntegrationException;
use Vinci\Domain\ERP\Product\ProductFactory;
use Vinci\Domain\ERP\Product\ProductRepository;
use Vinci\Infrastructure\ERP\BaseERPRepository;

class ProductRepositoryERP extends BaseERPRepository implements ProductRepository
{

    protected $factory;

    public function __construct(Repository $config, ProductFactory $factory)
    {
        parent::__construct($config);

        $this->factory = $factory;
    }

    public function getOneBySKU($sku)
    {
        try {

            $client = $this->buildClient('products.get_products');

            $response = $client->call('GETPRODUTOS', [
                'GETPRODUTOSInput' => [
                    'PCODLISTAPRECO-VARCHAR2-IN' => $this->config->get('erp.products_price_list'),
                    'PCODMATERIAL-VARCHAR2-IN' => $sku,
                    'PXML-XMLTYPE-OUT' => '',
                ]
            ]);

            try {

                $product = $this->parseResponse($response);

                return $this->factory->makeFromXmlObject($product);

            } catch (Exception $e) {
                throw new IntegrationException(sprintf('Error when importing the product #%s: %s', $sku, $e->getMessage()));
            }

        } catch (Exception $e) {
            throw $e;
        }

    }

    protected function parseResponse($response)
    {
        $response = simplexml_load_string($response->PXML->any);

        if(isset($response->ERRO)) {
            throw new IntegrationException($response->ERRO);
        }

        return $response;
    }

}