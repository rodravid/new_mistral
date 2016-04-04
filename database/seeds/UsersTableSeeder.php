<?php

use Doctrine\ORM\EntityManager;
use Illuminate\Database\Seeder;
use Vinci\Domain\ACL\Module\Module;
use Vinci\Domain\ACL\Module\ModuleRepository;
use Vinci\Domain\ACL\Permission\Permission;
use Vinci\Domain\ACL\Role\Role;
use Vinci\Domain\Admin\AdminRepository;
use Vinci\Domain\Customer\CustomerRepository;

class UsersTableSeeder extends Seeder
{
    private $adminRepository;

    private $customerRepository;

    private $moduleRepository;

    private $em;

    public function __construct(
        CustomerRepository $customerRepository,
        AdminRepository $adminRepository,
        ModuleRepository $moduleRepository,
        EntityManager $em
    )
    {
        $this->adminRepository = $adminRepository;
        $this->customerRepository = $customerRepository;
        $this->moduleRepository = $moduleRepository;
        $this->em = $em;
    }

    public function run()
    {

        $admin1 = $this->adminRepository->create([
            'name' => 'Felipe Alcântara',
            'email' => 'falcantara@webeleven.com.br',
            'password' => 'asdf123'
        ]);

        $admin2 = $this->adminRepository->create([
            'name' => 'Thiago',
            'email' => 'tcavallini@webeleven.com.br',
            'password' => '123'
        ]);

        $admin3 = $this->adminRepository->create([
            'name' => 'Wellington',
            'email' => 'wsilva@webeleven.com.br',
            'password' => '123'
        ]);

        $user1 = $this->adminRepository->create([
            'name' => 'Teste',
            'email' => 'teste@teste.com',
            'password' => '123'
        ]);

        $user2 = $this->adminRepository->create([
            'name' => 'Teste',
            'email' => 'teste2@teste.com',
            'password' => '123'
        ]);

        $user3 = $this->adminRepository->create([
            'name' => 'Teste',
            'email' => 'teste3@teste.com',
            'password' => '123'
        ]);

        $user4 = $this->adminRepository->create([
            'name' => 'Teste',
            'email' => 'teste4@teste.com',
            'password' => '123'
        ]);

        $user5 = $this->adminRepository->create([
            'name' => 'Teste',
            'email' => 'teste5@teste.com',
            'password' => '123'
        ]);

        $user6 = $this->adminRepository->create([
            'name' => 'Teste',
            'email' => 'teste6@teste.com',
            'password' => '123'
        ]);

        $user7 = $this->adminRepository->create([
            'name' => 'Teste',
            'email' => 'teste7@teste.com',
            'password' => '123'
        ]);

        $user8 = $this->adminRepository->create([
            'name' => 'Teste',
            'email' => 'teste8@teste.com',
            'password' => '123'
        ]);

        $superAdminRole = Role::make([
            'name' => 'super-admin',
            'description' => 'Super admin'
        ]);

        $adminRole = Role::make([
            'name' => 'admin',
            'description' => 'Admin'
        ]);

        $adminRole->assignPermission($this->em->getReference(Permission::class, 1));
        $adminRole->assignPermission($this->em->getReference(Permission::class, 2));

        $adminRole->assignModule($this->em->getReference(Module::class, 1));
        $adminRole->assignModule($this->em->getReference(Module::class, 2));
        $adminRole->assignModule($this->em->getReference(Module::class, 3));
        $adminRole->assignModule($this->em->getReference(Module::class, 4));

        $admin1->assignRole($superAdminRole);
        $admin2->assignRole($superAdminRole);
        $admin3->assignRole($superAdminRole);

        $user1->assignRole($adminRole);

        $this->em->persist($superAdminRole);
        $this->em->persist($adminRole);
        $this->em->persist($admin1);
        $this->em->persist($admin2);
        $this->em->persist($admin3);
        $this->em->persist($user1);
        $this->em->persist($user2);
        $this->em->persist($user3);
        $this->em->persist($user4);
        $this->em->persist($user5);
        $this->em->persist($user6);
        $this->em->persist($user7);
        $this->em->persist($user8);

        $this->em->flush();

    }
}