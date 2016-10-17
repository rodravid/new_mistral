<?php

namespace Vinci\Infrastructure\Address\City;

use Carbon\Carbon;
use Vinci\Domain\Address\City\CityRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineCityRepository extends DoctrineBaseRepository implements CityRepository
{

    public function getByState($state)
    {
        $query = $this->_em->createQuery('SELECT c FROM Vinci\Domain\Address\City\City c WHERE c.state = :id');

        $query->setParameter('id', $state);

        return $query->getResult();
    }

    public function exists($id)
    {
        $query = 'SELECT count(id) FROM ibge_cities WHERE id = ?;';

        $connection = $this->_em->getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute([
            $id
        ]);

        return $stmt->fetchColumn() > 0;
    }

    public function createCity(array $data)
    {
        $query = 'INSERT INTO ibge_cities 
                    (id, state_id, uf, name, created_at, updated_at) 
                  VALUES 
                    (:id, :state_id, :uf, :name, :created_at, :updated_at);';

        $connection = $this->_em->getConnection();
        $stmt = $connection->prepare($query);
        return $stmt->execute([
            'id' => intval($data['ibge_code']),
            'state_id' => intval($data['state_id']),
            'uf' => trim($data['uf']),
            'name' => trim($data['name']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    public function updateCity(array $data)
    {
        $query = 'UPDATE ibge_cities 
                  SET 
                    id = :id, 
                    state_id = :state_id, 
                    uf = :uf, 
                    name = :name,
                    updated_at = :updated_at
                  WHERE id = :id;';

        $connection = $this->_em->getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute([
            'id' => intval($data['ibge_code']),
            'state_id' => intval($data['state_id']),
            'uf' => trim($data['uf']),
            'name' => trim($data['name']),
            'updated_at' => Carbon::now()
        ]);
    }
}