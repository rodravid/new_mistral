<?php

namespace Vinci\Domain\Product\Repositories;

use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\Showcase\Showcase;

interface ProductRepository
{
    public function find($id);

    public function getOneById($id);

    public function findOneByIdAndChannel($id, $channel);

    public function getProductsById(array $productsIds);

    public function getFavoriteProductsByCustomer(CustomerInterface $customer, $perPage = 12, $keyword = null, $pageName = 'page');

    public function getFavoritesProductsIdsByCustomer(CustomerInterface $customer);

    public function getProductsByShowcase(Showcase $showcase, $perPage = 10);

}