<?php

use Doctrine\ORM\EntityManager;
use Illuminate\Database\Seeder;
use Vinci\Domain\ACL\Module\Module;

class ModulesTableSeeder extends Seeder
{

    private $em;

    public function __construct(
        EntityManager $em
    )
    {
        $this->em = $em;
    }

    public function run()
    {

        $modules = [
            $dashBoard = Module::make([
                'title' => 'Dashboard',
                'name' => 'dashboard',
                'url' => '/cms',
                'icon' => 'fa fa-tachometer'
            ]),

            $orders = Module::make([
                'title' => 'Pedidos',
                'name' => 'orders',
                'url' => '/cms/orders',
                'datatable_url' => '/cms/orders/datatable',
                'icon' => 'fa fa-shopping-bag'
            ]),

            $customers = Module::make([
                'title' => 'Clientes',
                'name' => 'customers',
                'url' => '/cms/customers',
                'datatable_url' => '/cms/customers/datatable',
                'icon' => 'fa fa-users'
            ]),

            $catalog = Module::make([
                'title' => 'Catálogo',
                'name' => 'catalog',
                'icon' => 'fa fa-tags'
            ]),

            $products = Module::make([
                'title' => 'Produtos',
                'name' => 'products',
                'url' => '/cms/products',
                'datatable_url' => '/cms/products/datatable',
                'icon' => 'fa fa-cubes'
            ])
                ->setParent($catalog),

            $wines = Module::make([
                'title' => 'Vinhos',
                'name' => 'wines',
                'url' => '/cms/wines',
                'datatable_url' => '/cms/wines/datatable',
                'icon' => 'fa fa-glass'
            ])
                ->setParent($catalog),

            $promotions = Module::make([
                'title' => 'Promoções',
                'name' => 'promotions',
                'icon' => 'fa fa-bullhorn'
            ]),

            $discountPromotion = Module::make([
                'title' => 'De/Por',
                'name' => 'discount-promotion',
                'url' => '/cms/discount-promotion',
                'datatable_url' => '/cms/discount-promotion/datatable',
                'icon' => 'fa fa-money'
            ])
                ->setParent($promotions),

            $freightPromotion = Module::make([
                'title' => 'Frete promocional',
                'name' => 'freight-promotion',
                'url' => '/cms/freight-promotion',
                'datatable_url' => '/cms/freight-promotion/datatable',
                'icon' => 'fa fa-truck'
            ])
                ->setParent($promotions),

            $clearanceSale = Module::make([
                'title' => 'Ponta de estoque',
                'name' => 'clearance-sale',
                'url' => '/cms/clearance-sale',
                'datatable_url' => '/cms/clearance-sale/datatable',
                'icon' => 'fa fa-clock-o'
            ])
                ->setParent($promotions),

            $kits = Module::make([
                'title' => 'Kits',
                'name' => 'kits',
                'url' => '/cms/kits',
                'datatable_url' => '/cms/kits/datatable',
                'icon' => 'fa fa-shopping-basket'
            ])
                ->setParent($catalog),

            $dollar = Module::make([
                'title' => 'Cotação do Dólar',
                'name' => 'dollar',
                'url' => '/cms/dollar',
                'datatable_url' => '/cms/dollar/datatable',
                'icon' => 'fa fa-money'
            ]),

            $delivery = Module::make([
                'title' => 'Entrega',
                'name' => 'delivery',
                'icon' => 'fa fa-truck'
            ]),

            $deadline = Module::make([
                'title' => 'Prazo de entrega padrão',
                'name' => 'deadline',
                'url' => '/cms/deadline',
                'datatable_url' => '/cms/deadline/datatable',
                'icon' => 'fa fa-clock-o'
            ])
                ->setParent($delivery),

            $deliveryTracks = Module::make([
                'title' => 'Faixas de CEP',
                'name' => 'delivery-tracks',
                'url' => '/cms/delivery-tracks',
                'datatable_url' => '/cms/delivery-tracks/datatable',
                'icon' => 'fa fa-list'
            ])
                ->setParent($delivery),

            $highlights = Module::make([
                'title' => 'Destaques',
                'name' => 'highlights',
                'icon' => 'fa fa-star'
            ]),

            $homeMainSlider = Module::make([
                'title' => 'Slider principal home',
                'name' => 'home-main-slider',
                'url' => '/cms/highlights/home-main-slider',
                'datatable_url' => '/cms/highlights/home-main-slider/datatable',
                'icon' => 'fa fa-photo',
                'create_button_text' => 'Novo banner'
            ])
                ->setParent($highlights),

            $newsletter = Module::make([
                'title' => 'Newsletter',
                'name' => 'newsletter',
                'url' => '/cms/newsletter',
                'datatable_url' => '/cms/newsletter/datatable',
                'icon' => 'fa fa-newspaper-o'
            ]),

            $administration = Module::make([
                'title' => 'Administração',
                'name' => 'administration',
                'icon' => 'fa fa-cog'
            ]),

            $users = Module::make([
                'title' => 'Usuários',
                'name' => 'users',
                'url' => '/cms/users',
                'datatable_url' => '/cms/users/datatable',
                'icon' => 'fa fa-user'
            ])
                ->setParent($administration),

            $groups = Module::make([
                'title' => 'Grupos',
                'name' => 'roles',
                'url' => '/cms/roles',
                'datatable_url' => '/cms/roles/datatable',
                'icon' => 'fa fa-users'
            ])
                ->setParent($administration)

        ];

        foreach ($modules as $module) {
            $this->em->persist($module);
        }

        $this->em->flush();
    }
}