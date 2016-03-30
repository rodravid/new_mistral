<?php

use Illuminate\Database\Seeder;
use Vinci\Domain\Admin\AdminRepository;
use Vinci\Domain\Customer\CustomerRepository;

class UsersTableSeeder extends Seeder
{
    private $adminRepository;

    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository, AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->customerRepository = $customerRepository;
    }

    public function run()
    {

        $this->adminRepository->create([
            'name' => 'Felipe',
            'email' => 'felipe.ralc@gmail.com',
            'password' => 'asdf123'
        ]);

    }
}