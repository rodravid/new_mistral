<?php

use Carbon\Carbon;
use Doctrine\ORM\EntityManager;
use Illuminate\Database\Seeder;
use Vinci\Domain\ACL\Module\Module;
use Vinci\Domain\ACL\Module\ModuleRepository;
use Vinci\Domain\ACL\Role\Role;
use Vinci\Domain\Address\AddressType;
use Vinci\Domain\Address\City\City;
use Vinci\Domain\Address\PublicPlace;
use Vinci\Domain\Admin\AdminRepository;
use Vinci\Domain\Common\Gender;
use Vinci\Domain\Common\Status;
use Vinci\Domain\Customer\Address\Address;
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
            'password' => 'asdf123',
            'status' => Status::ACTIVE
        ]);

        $admin2 = $this->adminRepository->create([
            'name' => 'Thiago',
            'email' => 'tcavallini@webeleven.com.br',
            'password' => '123',
            'status' => Status::ACTIVE
        ]);

        $admin3 = $this->adminRepository->create([
            'name' => 'Wellington',
            'email' => 'wsilva@webeleven.com.br',
            'password' => '123',
            'status' => Status::ACTIVE
        ]);

        $user1 = $this->adminRepository->create([
            'name' => 'Teste',
            'email' => 'teste@teste.com',
            'password' => '123',
            'status' => Status::ACTIVE
        ]);

//        $customer1 = $this->customerRepository->create([
//            'name' => 'Felipe Alcântara',
//            'email' => 'felipe.ralc@gmail.com',
//            'password' => '123',
//            'customer_type' => CustomerType::INDIVIDUAL,
//            'birthday' => Carbon::create(1994, 07, 19),
//            'cpf' => '43103602898',
//            'rg' => '441425094',
//            'issuing_body' => 'SSP',
//            'phone' => '1134032709',
//            'cellPhone' => '11968588930',
//            'commercialPhone' => '1129258403',
//            'gender' => Gender::MALE,
//            'status' => Status::ACTIVE
//        ]);
//
//        $address1 = new Address;
//
//        $address1->setType(new AddressType(AddressType::RESIDENTIAL))
//                ->setPostalCode(12906720)
//                ->setPublicPlace($this->em->getReference(PublicPlace::class, 1))
//                ->setAddress('Gilberto Augusto Mendes')
//                ->setNumber(350)
//                ->setDistrict('Vila Batista')
//                ->setCity($this->em->getReference(City::class, 3507605))
//                ->setNickname('Casa')
//                ->setLandmark('Próximo loja malwele')
//                ->setReceiver('Felipe');
//
//        $address2 = new Address;
//
//        $address2->setType(new AddressType(AddressType::RESIDENTIAL))
//            ->setPostalCode(25010000)
//            ->setPublicPlace($this->em->getReference(PublicPlace::class, 1))
//            ->setAddress('Amapá')
//            ->setNumber(221)
//            ->setDistrict('Parque dos Estados')
//            ->setCity($this->em->getReference(City::class, 3301702))
//            ->setNickname('Casa 2')
//            ->setLandmark('Próximo antigo borges')
//            ->setReceiver('Felipe');
//
//        $customer1->addAddress($address1)
//                  ->addAddress($address2)
//                  ->setMainAddress($address1);

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
        //$this->em->persist($user1);

        $this->em->flush();
        $this->em->clear();

    }
}