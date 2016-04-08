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

        $dashBoardModule = Module::make([
            'title' => 'Dashboard',
            'name' => 'dashboard',
            'url' => '/cms',
            'icon' => 'fa fa-tachometer'
        ]);

        $administrationModule = Module::make([
            'title' => 'Administração',
            'name' => 'administration',
            'icon' => 'fa fa-cog'
        ]);

        $usersModule = Module::make([
            'title' => 'Usuários',
            'name' => 'users',
            'url' => '/cms/users',
            'datatable_url' => '/cms/users/datatable',
            'icon' => 'fa fa-user'
        ]);

        $groupsModule = Module::make([
            'title' => 'Grupos',
            'name' => 'roles',
            'url' => '/cms/roles',
            'datatable_url' => '/cms/roles/datatable',
            'icon' => 'fa fa-users'
        ]);

        $usersModule->setParent($administrationModule);
        $groupsModule->setParent($administrationModule);

        $this->em->persist($dashBoardModule);
        $this->em->persist($administrationModule);
        $this->em->persist($usersModule);
        $this->em->persist($groupsModule);

        $this->em->flush();

    }
}