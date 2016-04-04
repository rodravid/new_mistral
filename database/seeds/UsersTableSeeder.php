<?php

use Doctrine\ORM\EntityManager;
use Illuminate\Database\Seeder;
use Vinci\Domain\ACL\Module\Module;
use Vinci\Domain\ACL\Module\ModuleRepository;
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

        $superAdminRole = Role::make([
            'name' => 'super-admin',
            'description' => 'Super admin'
        ]);

        $superAdminRole->assignModule($this->em->getReference(Module::class, 1));

        $admin1->assignRole($superAdminRole);
        $admin2->assignRole($superAdminRole);
        $admin3->assignRole($superAdminRole);

        $this->em->persist($superAdminRole);
        $this->em->persist($admin1);
        $this->em->persist($admin2);
        $this->em->persist($admin3);

        $this->em->flush();


    }
}