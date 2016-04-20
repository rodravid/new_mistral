<?php

use Carbon\Carbon;
use Doctrine\ORM\EntityManager;
use Illuminate\Database\Seeder;
use Vinci\Domain\ACL\Module\Module;
use Vinci\Domain\ACL\Module\ModuleRepository;
use Vinci\Domain\ACL\Role\Role;
use Vinci\Domain\Admin\AdminRepository;
use Vinci\Domain\Common\Gender;
use Vinci\Domain\Common\Status;
use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Domain\Customer\CustomerType;

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
        $this->customerRepository = $customerRepository;
        $this->adminRepository = $adminRepository;
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

        $customer1 = $this->customerRepository->create([
            'name' => 'Felipe Alcântara',
            'email' => 'felipe.ralc@gmail.com',
            'password' => '123',
            'customer_type' => CustomerType::INDIVIDUAL,
            'birthday' => Carbon::now(),
            'phone' => '11968588930',
            'gender' => Gender::MALE,
            'status' => Status::ACTIVE
        ]);

        $superAdminRole = Role::make([
            'title' => 'Super admin',
            'name' => 'super-admin'
        ]);

        $adminRole = Role::make([
            'title' => 'Admin',
            'name' => 'admin'
        ]);

        $adminRole->assignModule($this->em->getReference(Module::class, 1));
        $adminRole->assignModule($this->em->getReference(Module::class, 4));
        $adminRole->assignModule($this->em->getReference(Module::class, 10));
        $adminRole->assignModule($this->em->getReference(Module::class, 11));
        $adminRole->assignModule($this->em->getReference(Module::class, 12));

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

        $this->em->flush();
        $this->em->clear();

    }
}