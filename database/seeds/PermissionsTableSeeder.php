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

        $permission1 = Permission::make([
            'name' => 'cms.dashboard',
            'description' => 'Ver dashboard'
        ]);

        $permission2 = Permission::make([
            'name' => 'cms.users.list',
            'description' => 'Listar usuários'
        ]);

        $this->em->persist($permission1);
        $this->em->persist($permission2);

        $this->em->flush();

    }
}