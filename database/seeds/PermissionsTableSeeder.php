<?php

use Doctrine\ORM\EntityManager;
use Illuminate\Database\Seeder;
use Vinci\Domain\ACL\Permission\Permission;

class PermissionsTableSeeder extends Seeder
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

        $permissions = [
            ['name' => 'cms.dashboard.list', 'description' => 'Ver dashboard'],

            ['name' => 'cms.users.list', 'description' => 'Listar usuários'],
            ['name' => 'cms.users.create', 'description' => 'Criar usuários'],
            ['name' => 'cms.users.edit', 'description' => 'Editar usuários'],
            ['name' => 'cms.users.destroy', 'description' => 'Excluir usuários'],

            ['name' => 'cms.roles.list', 'description' => 'Listar grupos'],
            ['name' => 'cms.roles.create', 'description' => 'Criar grupos'],
            ['name' => 'cms.roles.edit', 'description' => 'Editar grupos'],
            ['name' => 'cms.roles.destroy', 'description' => 'Excluir grupos'],

            ['name' => 'cms.newsletter.list', 'description' => 'Listar newsletter'],
            ['name' => 'cms.newsletter.export', 'description' => 'Exportar newsletter'],

            ['name' => 'cms.deadline.list', 'description' => 'Listar datas de enterga'],
            ['name' => 'cms.deadline.create', 'description' => 'Definir nova data de entrega'],

            ['name' => 'cms.dollar.list', 'description' => 'Listar cotações do dólar'],
            ['name' => 'cms.dollar.create', 'description' => 'Definir nova cotação'],

            ['name' => 'cms.home-main-slider.list', 'description' => 'Listar destaques'],
            ['name' => 'cms.home-main-slider.create', 'description' => 'Criar novo destaque'],
            ['name' => 'cms.home-main-slider.edit', 'description' => 'Editar destaque'],
            ['name' => 'cms.home-main-slider.destroy', 'description' => 'Excluir destaque'],

            ['name' => 'cms.countries.list', 'description' => 'Listar países'],
            ['name' => 'cms.countries.create', 'description' => 'Cadastrar países'],
            ['name' => 'cms.countries.edit', 'description' => 'Editar países'],
            ['name' => 'cms.countries.destroy', 'description' => 'Excluir países'],

            ['name' => 'cms.regions.list', 'description' => 'Listar regiões'],
            ['name' => 'cms.regions.create', 'description' => 'Cadastrar regiões'],
            ['name' => 'cms.regions.edit', 'description' => 'Editar regiões'],
            ['name' => 'cms.regions.destroy', 'description' => 'Excluir regiões'],

            ['name' => 'cms.producers.list', 'description' => 'Listar produtores'],
            ['name' => 'cms.producers.create', 'description' => 'Cadastrar produtores'],
            ['name' => 'cms.producers.edit', 'description' => 'Editar produtores'],
            ['name' => 'cms.producers.destroy', 'description' => 'Excluir produtores'],

            ['name' => 'cms.grapes.list', 'description' => 'Listar uvas'],
            ['name' => 'cms.grapes.create', 'description' => 'Cadastrar uvas'],
            ['name' => 'cms.grapes.edit', 'description' => 'Editar uvas'],
            ['name' => 'cms.grapes.destroy', 'description' => 'Excluir uvas'],

            ['name' => 'cms.product-type.list', 'description' => 'Listar tipos de produtos'],
            ['name' => 'cms.product-type.create', 'description' => 'Cadastrar novo tipo de produto'],
            ['name' => 'cms.product-type.edit', 'description' => 'Editar tipos de produtos'],
            ['name' => 'cms.product-type.destroy', 'description' => 'Excluir tipos de produtos'],

            ['name' => 'cms.customers.list', 'description' => 'Listar clientes'],
            ['name' => 'cms.customers.show', 'description' => 'Visualizar cliente'],
            ['name' => 'cms.customers.create', 'description' => 'Cadastrar novo cliente'],
            ['name' => 'cms.customers.edit', 'description' => 'Editar clientes'],
            ['name' => 'cms.customers.destroy', 'description' => 'Excluir clientes'],

            ['name' => 'cms.delivery-tracks.list', 'description' => 'Listar faixas'],
            ['name' => 'cms.delivery-tracks.create', 'description' => 'Cadastrar nova faixa'],
            ['name' => 'cms.delivery-tracks.edit', 'description' => 'Editar faixa'],
            ['name' => 'cms.delivery-tracks.destroy', 'description' => 'Excluir faixas'],

        ];

        foreach ($permissions as $permission) {
            $this->em->persist(
                Permission::make([
                    'name' => $permission['name'],
                    'description' => $permission['description']
                ])
            );
        }

        $this->em->flush();
        $this->em->clear();

    }
}