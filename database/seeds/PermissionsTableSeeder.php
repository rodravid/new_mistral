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
            ['name' => 'cms.dashboard', 'description' => 'Ver dashboard'],

            ['name' => 'cms.users.list', 'description' => 'Listar usuários'],
            ['name' => 'cms.users.create', 'description' => 'Criar usuários'],
            ['name' => 'cms.users.edit', 'description' => 'Editar usuários'],
            ['name' => 'cms.users.destroy', 'description' => 'Excluir usuários'],

            ['name' => 'cms.groups.list', 'description' => 'Listar grupos'],
            ['name' => 'cms.groups.create', 'description' => 'Criar grupos'],
            ['name' => 'cms.groups.edit', 'description' => 'Editar grupos'],
            ['name' => 'cms.groups.destroy', 'description' => 'Excluir grupos'],
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

    }
}