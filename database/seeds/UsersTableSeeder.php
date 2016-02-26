<?php

use Illuminate\Database\Seeder;
use Vinci\Domain\User\UserRepository;

class UsersTableSeeder extends Seeder
{

    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {

        $this->repository->create([
            'name' => 'Felipe',
            'email' => 'felipe.ralc@gmail.com',
            'password' => bcrypt('asdf123'),
        ]);

    }
}