<?php

namespace Vinci\Infrastructure\ERP\Product;

use Carbon\Carbon;
use Vinci\Domain\Common\Status;
use Vinci\Domain\ERP\Product\Product;
use Vinci\Domain\ERP\Product\ProductFactory as ProductFactoryInterface;

class ProductFactory implements ProductFactoryInterface
{
    public function makeFromXmlObject($xmlObject)
    {
        $data = [];
        $data["channels"][0] = 1;
        $data["type"]["id"] = 2;
        $data["country_id"] = $this->normalizeValue($xmlObject->COD_PAIS);
        $data["region_id"] = $this->normalizeValue($xmlObject->COD_REGIAO);
        $data["producer_id"] = $this->normalizeValue($xmlObject->COD_PRODUTOR);
        $data['product_type_id'] = $this->normalizeValue($xmlObject->COD_TIPO);
        $data["sku"] = $this->normalizeValue($xmlObject->CODIGO_PRODUTO);
        $data["title"] = $this->normalizeValue($xmlObject->NOME_NO_SITE);
        $data["shortDescription"] = $this->normalizeValue($xmlObject->DESCRICAO_SITE_MARKETING);
        $data["description"] = $this->normalizeValue($xmlObject->DESCRICAO_SITE_LONGA);
        $data["packSize"] = $this->normalizeValue($xmlObject->GRF_CAIXA);
        $data["startsAt"] = Carbon::now()->format('d/m/Y H:i');
        $data["expirationAt"] = null;
        $data["status"] = Status::ACTIVE;
        $data["online"] = $xmlObject->LISTADO_NO_SITE == 'SIM' ? true : false;
        $data["slug"] = null;

        /**
         * Dimensions
         */
        $data['dimension']['weight'] = $this->normalizeValue($xmlObject->PESO);

        /**
         * SEO
         */
        $data["seoTitle"] = "";
        $data["seoDescription"] = "";
        $data["seoKeywords"] = "";

        /**
         * Price
         */
        $data["price"][0]["channel"]["id"] = 1;
        $data["price"][0]["price"] = $this->normalizeValue($xmlObject->PRECOGARRAFA_USD);
        $data["price"][0]["currency_amount"] = $this->normalizeValue($xmlObject->VLR_COTACAO);
        $data["price"][0]["aliquot_ipi"] = $this->normalizeValue($xmlObject->ALIQ_IPI_SP);
        $data["price"][0]["discount_type"] = null;
        $data["price"][0]["discount_value"] = null;
        $data["should_import_price"] = 1;

        /**
         * Stock
         */
        $data["should_import_stock"] = 1;

        /**
         * Attributes
         */
        //vintage
        $data["attributes"][0]["attribute_id"] = 1;
        $data["attributes"][0]["value"] = $this->normalizeValue($xmlObject->SAFRA);

        //alcoholic_strength
        $data["attributes"][1]["attribute_id"] = 2;
        $data["attributes"][1]["value"] = $this->normalizeValue($xmlObject->TEOR_ALCOOLICO);

        //temperature
        $data["attributes"][2]["attribute_id"] = 3;
        $data["attributes"][2]["value"] = $this->normalizeValue($xmlObject->TEMPERATURA_DE_SERVICO);

        //decantation
        $data["attributes"][3]["attribute_id"] = 4;
        $data["attributes"][3]["value"] = $this->normalizeValue($xmlObject->SUGESTAO_DE_DECANTACAO);

        //vineyard
        $data["attributes"][4]["attribute_id"] = 5;
        $data["attributes"][4]["value"] = $this->normalizeValue($xmlObject->VINHEDOS);

        //vinification
        $data["attributes"][5]["attribute_id"] = 6;
        $data["attributes"][5]["value"] = $this->normalizeValue($xmlObject->VINIFICACAO);

        //blend
        $data["attributes"][6]["attribute_id"] = 7;
        $data["attributes"][6]["value"] = $this->normalizeValue($xmlObject->UVA_SITE);

        //gastronomy_pairings
        $data["attributes"][7]["attribute_id"] = 8;
        $data["attributes"][7]["value"] = $this->normalizeValue($xmlObject->COMBINACOES_ENOGASTRONOMICAS);

        //maturation
        $data["attributes"][8]["attribute_id"] = 9;
        $data["attributes"][8]["value"] = $this->normalizeValue($xmlObject->MATURACAO);

        //full_bodied
        $data["attributes"][9]["attribute_id"] = 10;
        $data["attributes"][9]["value"] = $this->normalizeValue($xmlObject->CORPO);

        //aging_potential
        $data["attributes"][10]["attribute_id"] = 11;
        $data["attributes"][10]["value"] = $this->normalizeValue($xmlObject->CORPO);

        //bottle_size
        $data["attributes"][11]["attribute_id"] = 12;
        $data["attributes"][11]["value"] = $this->normalizeValue($xmlObject->TIPO_GFA);

        return $this->newInstance($data);
    }

    private function normalizeValue($value)
    {
        if ($value == "NULL" || empty($value)) {
            return null;
        }

        return (string) $value;
    }

    protected function newInstance(array $attributes = [])
    {
        return new Product($attributes);
    }
}