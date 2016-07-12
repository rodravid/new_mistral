<?php

namespace Vinci\Infrastructure\ERP\Product;

use Exception;
use Illuminate\Contracts\Config\Repository;
use Vinci\App\Integration\Exceptions\IntegrationException;
use Vinci\Domain\ERP\Product\ProductFactory;
use Vinci\Domain\ERP\Product\ProductRepository;
use Vinci\Infrastructure\ERP\BaseERPRepository;
use Vinci\Infrastructure\Exceptions\EmptyResponseException;

class ProductRepositoryERP extends BaseERPRepository implements ProductRepository
{

    protected $factory;

    public function __construct(Repository $config, ProductFactory $factory)
    {
        parent::__construct($config);

        $this->factory = $factory;
    }

    public function getStoreCode()
    {
        return $this->config->get('erp.products_price_list');
    }

    public function getOneBySKU($sku)
    {
        try {

            $client = $this->buildClient('products.get_products');

            $response = $client->call('GETPRODUTOS', [
                'GETPRODUTOSInput' => [
                    'PCODLISTAPRECO-VARCHAR2-IN' => $this->getStoreCode(),
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

    public function getStock($sku)
    {

        try {

            $client = $this->buildClient('products.get_stock');

            $response = $client->call('CONSULTASALDOESTOQUE', [
                'CONSULTASALDOESTOQUEInput' => [
                    'PCODLISTAPRECO-VARCHAR2-IN' => $this->getStoreCode(),
                    'PCODMATERIAL-VARCHAR2-IN' => $sku,
                    'PXML-XMLTYPE-OUT' => '',
                ]
            ]);

            try {

                $stock = $this->parseResponse($response);

                return intval($stock);

            } catch (Exception $e) {
                throw new IntegrationException(sprintf('Error when importing stock of the product #%s: %s', $sku, $e->getMessage()));
            }

        } catch (Exception $e) {
            throw $e;
        }

    }

    public function getAll()
    {
        try {

            $client = $this->buildClient('products.get_current_products');

            $response = $client->call('GETPRODUTOSATUAIS', [
                'GETPRODUTOSATUAISInput' => [
                    'PCODLISTAPRECO-VARCHAR2-IN' => $this->getStoreCode(),
                    'PXML-XMLTYPE-OUT' => '',
                ]
            ]);

            try {

                $products = $this->parseResponse($response, true);

                return $this->factory->makeListFromXmlObject($products);

            } catch (EmptyResponseException $e) {

                return [];

            } catch (Exception $e) {
                throw new IntegrationException(sprintf('Error when getting products list from ERP: %s', $e->getMessage()));
            }

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getNew()
    {
        try {

            $client = $this->buildClient('products.get_new_products');

            $response = $client->call('GETPRODUTOSNOVOS', [
                'GETPRODUTOSNOVOSInput' => [
                    'PMARCA-VARCHAR2-IN' => $this->getStoreCode(),
                    'PXML-XMLTYPE-OUT' => '',
                ]
            ]);

            try {

                $products = $this->parseResponse($response, true);

                return $this->factory->makeListFromXmlObject($products);

            } catch (EmptyResponseException $e) {

                return [];

            } catch (Exception $e) {
                throw new IntegrationException(sprintf('Error when getting new products list from ERP: %s', $e->getMessage()));
            }

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getChanged()
    {
        try {

            $client = $this->buildClient('products.get_changed_products');

            $response = $client->call('GETPRODUTOSALTERADOS', [
                'GETPRODUTOSALTERADOSInput' => [
                    'PMARCA-VARCHAR2-IN' => $this->getStoreCode(),
                    'PXML-XMLTYPE-OUT' => '',
                ]
            ]);

            try {

                $products = $this->parseResponse($response, true);

                return $this->factory->makeListFromXmlObject($products);

            } catch (EmptyResponseException $e) {
                return [];
            } catch (Exception $e) {
                throw new IntegrationException(sprintf('Error when getting changed products list from ERP: %s', $e->getMessage()));
            }

        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function parseResponse($response, $includeRoot = false)
    {
        if (isset($response->PXML->any)) {
            $response = $response->PXML->any;
        } else {
            throw new EmptyResponseException('Empty response.');
        }

        if ($includeRoot) {
            $response = sprintf('<data>%s</data>', $response);
        }

        $response = simplexml_load_string($response);

        if(isset($response->ERRO)) {
            throw new IntegrationException($response->ERRO);
        }

        if(isset($response->PERRO)) {
            throw new IntegrationException($response->PERRO);
        }

        return $response;
    }

}