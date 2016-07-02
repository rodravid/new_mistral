<?php

namespace Vinci\Domain\Product\Repositories;

use Doctrine\ORM\QueryBuilder;
use Vinci\Domain\Country\Country;
use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\ProductType\ProductType;
use Vinci\Domain\Promotion\Types\Discount\DiscountPromotionInterface;

interface ProductRepository
{
    public function find($id);

    public function getOneById($id);

    public function getAllValidForSelectArray();

    public function findOneByIdAndChannel($id, $channel);

    public function getProductsById(array $productsIds);

    public function getFavoriteProductsByCustomer(CustomerInterface $customer, $perPage = 12, $keyword = null, $pageName = 'page');

    public function getFavoritesProductsIdsByCustomer(CustomerInterface $customer);

    public function getProductsByShowcase($showcase, $perPage = 10, $page = 1, $path = '/');

    public function getProductsByCountryAndType(Country $country, ProductType $type, $quantity = 4, array $except = [], $randomize = false);

    public function getProductsIdsFromPromotion(DiscountPromotionInterface $promotion);

    public function getProductsFromCountries(array $countries);

    public function getProductsFromRegions(array $regions);

    public function getProductsFromProducers(array $producers);

    public function getProductsFromTypes(array $types);

    public function getAvailableProductsFromTypes(array $types);

    public function getRandomProducts($quantity = 4);

}