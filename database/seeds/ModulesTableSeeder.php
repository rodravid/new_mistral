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
                'icon' => 'fa fa-shopping-bag',
                'create_button_text' => 'Novo pedido',
                'editing_text' => 'Editando pedido'
            ]),

            $customers = Module::make([
                'title' => 'Clientes',
                'name' => 'customers',
                'url' => '/cms/customers',
                'datatable_url' => '/cms/customers/datatable',
                'icon' => 'fa fa-users',
                'create_button_text' => 'Novo cliente',
                'editing_text' => 'Editando cliente'
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
                'icon' => 'fa fa-cubes',
                'create_button_text' => 'Novo produto',
                'editing_text' => 'Editando produto'
            ])
                ->setParent($catalog),

            $wines = Module::make([
                'title' => 'Vinhos',
                'name' => 'wines',
                'url' => '/cms/wines',
                'datatable_url' => '/cms/wines/datatable',
                'icon' => 'fa fa-glass',
                'create_button_text' => 'Novo vinho',
                'editing_text' => 'Editando vinho'
            ])
                ->setParent($catalog),

            $kits = Module::make([
                'title' => 'Kits',
                'name' => 'kits',
                'url' => '/cms/kits',
                'datatable_url' => '/cms/kits/datatable',
                'icon' => 'fa fa-shopping-basket',
                'create_button_text' => 'Novo kit',
                'editing_text' => 'Editando kit'
            ])
                ->setParent($catalog),

            $grapes = Module::make([
                'title' => 'Uvas',
                'name' => 'grapes',
                'url' => '/cms/grapes',
                'datatable_url' => '/cms/grapes/datatable',
                'icon' => 'fa fa-pagelines',
                'create_button_text' => 'Nova uva',
                'editing_text' => 'Editando uva'
            ])
                ->setParent($catalog),

            $productType = Module::make([
                'title' => 'Tipos de produtos',
                'name' => 'product-type',
                'url' => '/cms/product-type',
                'datatable_url' => '/cms/product-type/datatable',
                'icon' => 'fa fa-tags',
                'create_button_text' => 'Novo tipo de produto',
                'editing_text' => 'Editando tipo de produto'
            ])
                ->setParent($catalog),

            $countries = Module::make([
                'title' => 'Países',
                'name' => 'countries',
                'url' => '/cms/countries',
                'datatable_url' => '/cms/countries/datatable',
                'icon' => 'fa fa-flag',
                'create_button_text' => 'Novo país',
                'editing_text' => 'Editando país'
            ])
                ->setParent($catalog),

            $regions = Module::make([
                'title' => 'Regiões',
                'name' => 'regions',
                'url' => '/cms/regions',
                'datatable_url' => '/cms/regions/datatable',
                'icon' => 'fa fa-map-marker',
                'create_button_text' => 'Nova região',
                'editing_text' => 'Editando região'
            ])
                ->setParent($catalog),

            $producers = Module::make([
                'title' => 'Produtores',
                'name' => 'producers',
                'url' => '/cms/producers',
                'datatable_url' => '/cms/producers/datatable',
                'icon' => 'fa fa-users',
                'create_button_text' => 'Novo produtor',
                'editing_text' => 'Editando produtor'
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
                'icon' => 'fa fa-money',
                'create_button_text' => 'Nova promoção',
                'editing_text' => 'Editando promoção'
            ])
                ->setParent($promotions),

            $freightPromotion = Module::make([
                'title' => 'Frete promocional',
                'name' => 'freight-promotion',
                'url' => '/cms/freight-promotion',
                'datatable_url' => '/cms/freight-promotion/datatable',
                'icon' => 'fa fa-truck',
                'create_button_text' => 'Nova promoção',
                'editing_text' => 'Editando promoção'
            ])
                ->setParent($promotions),

            $clearanceSale = Module::make([
                'title' => 'Ponta de estoque',
                'name' => 'clearance-sale',
                'url' => '/cms/clearance-sale',
                'datatable_url' => '/cms/clearance-sale/datatable',
                'icon' => 'fa fa-clock-o',
                'create_button_text' => 'Nova promoção',
                'editing_text' => 'Editando promoção'
            ])
                ->setParent($promotions),

            $dollar = Module::make([
                'title' => 'Cotação do Dólar',
                'name' => 'dollar',
                'url' => '/cms/dollar',
                'datatable_url' => '/cms/dollar/datatable',
                'icon' => 'fa fa-money',
                'create_button_text' => 'Nova cotação',
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
                'icon' => 'fa fa-clock-o',
                'create_button_text' => 'Novo prazo de entrega'
            ])
                ->setParent($delivery),

            $deliveryTracks = Module::make([
                'title' => 'Faixas de CEP',
                'name' => 'delivery-tracks',
                'url' => '/cms/delivery-tracks',
                'datatable_url' => '/cms/delivery-tracks/datatable',
                'icon' => 'fa fa-list',
                'create_button_text' => 'Nova faixa de CEP',
                'editing_text' => 'Editando faixa de CEP'
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
                'create_button_text' => 'Novo destaque',
                'editing_text' => 'Editando destaque'
            ])
                ->setParent($highlights),

            $newsletter = Module::make([
                'title' => 'Newsletter',
                'name' => 'newsletter',
                'url' => '/cms/newsletter',
                'datatable_url' => '/cms/newsletter/datatable',
                'icon' => 'fa fa-newspaper-o',
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
                'icon' => 'fa fa-user',
                'create_button_text' => 'Novo usuário',
                'editing_text' => 'Editando usuário'
            ])
                ->setParent($administration),

            $groups = Module::make([
                'title' => 'Grupos',
                'name' => 'roles',
                'url' => '/cms/roles',
                'datatable_url' => '/cms/roles/datatable',
                'icon' => 'fa fa-users',
                'create_button_text' => 'Novo grupo',
                'editing_text' => 'Editando grupo'
            ])
                ->setParent($administration)

        ];

        foreach ($modules as $module) {
            $this->em->persist($module);
        }

        $this->em->flush();
    }
}