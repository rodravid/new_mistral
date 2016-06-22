<?php

namespace Vinci\Domain\Product\Repositories;

use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\Promotion\Types\Discount\DiscountPromotionInterface;

interface ProductRepository
{
    public function find($id);

    public function getOneById($id);

    public function findOneByIdAndChannel($id, $channel);

    public function getProductsById(array $productsIds);

    public function getFavoriteProductsByCustomer(CustomerInterface $customer, $perPage = 12, $keyword = null, $pageName = 'page');

    public function getFavoritesProductsIdsByCustomer(CustomerInterface $customer);

    public function getProductsByShowcase($showcase, $perPage = 10, $page = 1, $path = '/');

    public function registerNotify($data);

    public function getProductsIdsFromPromotion(DiscountPromotionInterface $promotion);
    
}