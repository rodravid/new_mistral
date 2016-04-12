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

            ['name' => 'cms.roles.list', 'description' => 'Listar grupos'],
            ['name' => 'cms.roles.create', 'description' => 'Criar grupos'],
            ['name' => 'cms.roles.edit', 'description' => 'Editar grupos'],
            ['name' => 'cms.roles.destroy', 'description' => 'Excluir grupos'],

            ['name' => 'cms.newsletter.list', 'description' => 'Listar newsletter'],
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