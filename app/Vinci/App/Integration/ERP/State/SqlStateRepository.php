<?php
namespace Vinci\App\Integration\ERP\State;

class SqlStateRepository implements StateRepository
{

    public function syncStates($states, $detach = false)
    {
        $result = [
            'attached' => 0,
            'updated' => 0
        ];

        foreach ($states as $state) {

            $id = $state['ibge_code'];

            if ($this->exists($id)) {
                $this->update($state, $id);
                $result['updated']++;
            } else {
                $this->create($state);
                $result['attached']++;
            }

        }

        return $result;
    }

    public function exists($id)
    {
        $query = 'SELECT count(ibge_code) FROM w11_erp_states WHERE ibge_code = ?;';
        $stmt = $this->getStatement($query, [$id]);
        return $stmt->fetchColumn() > 0;
    }

    public function create(array $data)
    {
        $query = 'INSERT INTO w11_erp_states (`uf`, `name`, `country_id`, `ibge_code`) VALUES (?,?,?,?);';

        return $this->getStatement($query, [
            trim($data['uf']),
            trim($data['name']),
            intval($data['country_id']),
            intval($data['ibge_code'])
        ]);
    }

    public function update($data, $id)
    {
        $query = 'UPDATE w11_erp_states SET uf = :uf, name = :name, country_id = :country_id, ibge_code = :ibge_code WHERE ibge_code = :id;';

        return $this->getStatement($query, [
            'uf' => trim($data['uf']),
            'name' => trim($data['name']),
            'country_id' => intval($data['country_id']),
            'ibge_code' => intval($data['ibge_code']),
            'id' => $id
        ]);
    }

    public function getAllStatesOfCountry($countryId)
    {
        $query = 'SELECT * FROM w11_erp_states WHERE country_id = ?;';
        $stmt = $this->getStatement($query, [$countryId]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}