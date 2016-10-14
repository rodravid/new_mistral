<?php
namespace Vinci\Infrastructure\Address\State;

use Carbon\Carbon;
use Vinci\Domain\Address\State\StateRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineStateRepository extends DoctrineBaseRepository implements StateRepository
{

    public function getByCountry($country)
    {
        $query = $this->_em->createQuery('SELECT s FROM Vinci\Domain\Address\State\State s WHERE s.country = :id');

        $query->setParameter('id', $country);

        return $query->getResult();
    }

    public function getById($id)
    {
        $query = $this->_em->createQuery('SELECT s FROM Vinci\Domain\Address\State\State s WHERE s.id = :id');
        $query->setParameter('id', $id);

        return $query->getOneOrNullResult();
    }

    public function syncState($state)
    {
        if ($localState = $this->getByIdThroughSQL($state['ibge_code'])) {
            $this->update($state);

        } else {
            $this->create($state);

        }
    }

    public function syncStates($states, $detach = false)
    {
        foreach ($states as $state) {
            if ($localState = $this->getByIdThroughSQL($state['ibge_code'])) {
                $this->update($state);

            } else {
                $this->create($state);

            }
        }
    }

    public function getByIdThroughSQL($id)
    {
        $sql = "SELECT * FROM ibge_states WHERE id = :id";
        $connection = $this->_em->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function update($state)
    {

        $sql = "UPDATE ibge_states 
                SET
                  uf = :uf, 
                  name = :name, 
                  updated_at = :updated_at
                WHERE id = :id";

        $connection = $this->_em->getConnection();

        $stmt = $connection->prepare($sql);

        $stmt->execute([
            'id' => $state['ibge_code'],
//            'country_id' => $state['country_id'],
            'uf' => $state['uf'],
            'name' => $state['name'],
            'updated_at' => Carbon::now()
        ]);

    }

    public function create($state)
    {
        $sql = "INSERT INTO ibge_states
                  (country_id,
                   uf,
                   name,
                   created_at,
                   updated_at)
                VALUES
                  (:country_id,
                   :uf,
                   :name,
                   :created_at,
                   :updated_at)";

        $connection = $this->_em->getConnection();

        $stmt = $connection->prepare($sql);

        $stmt->execute([
            'country_id' => '1058',
            'uf' => $state['uf'],
            'name' => $state['name'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}