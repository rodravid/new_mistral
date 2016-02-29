<?php

use Illuminate\Database\Seeder;
use Vinci\Domain\User\Customer\CustomerRepository;

class UsersTableSeeder extends Seeder
{

    private $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {

        $user = $this->repository->create([
            'name' => 'Felipe',
            'email' => 'felipe.ralc@gmail.com'
        ]);

        $this->repository->createProfile([
            'password' => bcrypt('asdf123'),
            'type' => 'M',
            'document' => '431.036.028-98'
        ], $user->id);

    }
}