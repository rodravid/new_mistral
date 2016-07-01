<?php

namespace Vinci\App\Website\Auth;

use Exception;
use Log;
use SoapClient;
use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\Customer\CustomerRepository;

class OldAuthService
{

    protected $client;

    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;

        $this->client = $this->buildClient();
    }

    public function auth(CustomerInterface $customer, $password)
    {
        try {

            $result = $this->client->Autentica([
                'email' => $customer->getEmail(),
                'senha' => $password
            ]);

            $this->validadeResult($result);

            $this->updateCustomer($customer, $password);

        } catch (Exception $e) {

            Log::error(sprintf('Erro autenticação servico de clientes antigos: %s', $e->getMessage()));

            throw $e;
        }
    }

    private function updateCustomer(CustomerInterface $customer, $password)
    {
        $customer->setPassword($password);
        $customer->clearCryptKey();

        $this->customerRepository->save($customer);
    }

    private function validadeResult($result)
    {
        $result = $result->AutenticaResult;

        if ($result === false) {
            throw new Exception('Usuário ou senha incorretos no serviço de login de clientes antigos.');
        }
    }

    private function buildClient()
    {
        return new SoapClient('http://200.219.242.45/vinciapi/vinciws.asmx?WSDL');
    }

}