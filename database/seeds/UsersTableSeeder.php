<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    private $adminRepository;

    public function __construct(\Vinci\Domain\Admin\AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
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