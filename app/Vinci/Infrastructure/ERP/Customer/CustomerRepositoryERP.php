<?php

namespace Vinci\Infrastructure\ERP\Customer;

use Illuminate\Contracts\Config\Repository;
use Vinci\Domain\ERP\Customer\Customer;
use Vinci\Domain\ERP\Customer\CustomerRepository;
use Vinci\Infrastructure\ERP\BaseERPRepository;

class CustomerRepositoryERP extends BaseERPRepository implements CustomerRepository
{
    public function __construct(Repository $config)
    {
        parent::__construct($config);
    }

    public function create(Customer $customer)
    {
        try {

            $client = $this->buildClient('customers.create_customer');

            $response = $client->call('CRIAPESSOA', [
                'CRIAPESSOAInput' => [
                    'PAPELIDO-VARCHAR2-IN' => '',
                    'PAPELIDOFILIALPADRAO-VARCHAR2-IN' => '',
                    'PBAIRRO-VARCHAR2-IN' => '',
                    'PBAIRROCOBRANCA-VARCHAR2-IN' => '',
                    'PCAIXAPOSTAL-VARCHAR2-IN' => '',
                    'PCAIXAPOSTALCOBRANCA-VARCHAR2-IN' => '',
                    'PCEP-VARCHAR2-IN' => '',
                    'PCEPCAIXAPOSTAL-VARCHAR2-IN' => '',
                    'PCEPCOBRANCA-VARCHAR2-IN' => '',
                    'PCGC-VARCHAR2-IN' => '',
                    'PCODCENTROCUSTOPADRAO-NUMBER-IN' => '',
                    'PCODCLASSIFCLIENTE-VARCHAR2-IN' => '',
                    'PCODCLASSIFPESSOA-VARCHAR2-IN' => '',
                    'PCODCLASSIFPESSOAFISICA-VARCHAR2-IN' => '',
                    'PCODCLASSIFPESSOAJURIDICA-VARCHAR2-IN' => '',
                    'PCODCONDICAOPAGTOPADRAO-VARCHAR2-IN' => '',
                    'PCODCONDICAOPAGTOPADRAOCLI-VARCHAR2-IN' => '',
                    'PCODCONDICAOPGTOPADRAOFORN-VARCHAR2-IN' => '',
                    'PCODCONTACONTABILPADRAO-VARCHAR2-IN' => '',
                    'PCODGRUPOCONTABILPADRAO-VARCHAR2-IN' => '',
                    'PCODIBGEMUN-NUMBER-IN' => '',
                    'PCODIBGEMUNCOB-NUMBER-IN' => '',
                    'PCODIBGEPAIS-NUMBER-IN' => '',
                    'PCODIBGEPAISCOB-NUMBER-IN' => '',
                    'PCODIBGEUF-NUMBER-IN' => '',
                    'PCODIBGEUFCOB-NUMBER-IN' => '',
                    'PCODLIQDCFINANCPADRAO-VARCHAR2-IN' => '',
                    'PCODPRODUTOSERVICOPADRAO-VARCHAR2-IN' => '',
                    'PCODPRODUTOSERVICOPADRAOCLI-VARCHAR2-IN' => '',
                    'PCODPROJETOPADRAOCLIENTE-VARCHAR2-IN' => '',
                    'PCODPROJETOPADRAOFORNCD-VARCHAR2-IN' => '',
                    'PCODREGIAO-VARCHAR2-IN' => '',
                    'PCODSITCLIENTE-NUMBER-IN' => '',
                    'PCODTIPOOCUPACAO-VARCHAR2-IN' => '',
                    'PCODTIPOPESSOA-VARCHAR2-IN' => '',
                    'PCODUNIDADENEGOCIO-VARCHAR2-IN' => '',
                    'PCOMPLEMENTOENDER-VARCHAR2-IN' => '',
                    'PCOMPLEMENTOENDERCOBRANCA-VARCHAR2-IN' => '',
                    'PCONTATO-VARCHAR2-IN' => '',
                    'PCPF-VARCHAR2-IN' => '',
                    'PDDD-NUMBER-IN' => '',
                    'PDDDCOBRANCA-NUMBER-IN' => '',
                    'PDDDFAX-NUMBER-IN' => '',
                    'PDTCADASTRO-DATE-IN' => '',
                    'PDTREGJUNTACOMERCIAL-DATE-IN' => '',
                    'PEMAIL-VARCHAR2-IN' => '',
                    'PEMAILNF-VARCHAR2-IN' => '',
                    'PENDER-VARCHAR2-IN' => '',
                    'PENDERCOBRANCA-VARCHAR2-IN' => '',
                    'PFAX-VARCHAR2-IN' => '',
                    'PFPAS-NUMBER-IN' => '',
                    'PIDPESSOA-VARCHAR2-IN' => '',
                    'PINDATIVA-VARCHAR2-IN' => '',
                    'PINDCALCULOIRRFBAIXO-VARCHAR2-IN' => '',
                    'PINDCLIENTE-VARCHAR2-IN' => '',
                    'PINDDEDUCAODEPENDENTEIRRF-VARCHAR2-IN' => '',
                    'PINDDISPENSACALCULOINSSRET-VARCHAR2-IN' => '',
                    'PINDDISPENSARECOLINSS-VARCHAR2-IN' => '',
                    'PINDFORNCD-VARCHAR2-IN' => '',
                    'PINSCRESTADUAL-VARCHAR2-IN' => '',
                    'PINSCRESTADUALFIS-VARCHAR2-IN' => '',
                    'PINSCRIMUNIC-VARCHAR2-IN' => '',
                    'PNOME-VARCHAR2-IN' => '',
                    'PNUMAGENCIACCPADRAO-VARCHAR2-IN' => '',
                    'PNUMBACENCCPADRAO-VARCHAR2-IN' => '',
                    'PNUMBACENPADRAO-VARCHAR2-IN' => '',
                    'PNUMCCPADRAO-VARCHAR2-IN' => '',
                    'PNUMCLASSESALARIOBASE-NUMBER-IN' => '',
                    'PNUMENDER-VARCHAR2-IN' => '',
                    'PNUMENDERCOBRANCA-VARCHAR2-IN' => '',
                    'PNUMINSCRINSS-VARCHAR2-IN' => '',
                    'PNUMPISPASEPCI-NUMBER-IN' => '',
                    'PNUMREGJUNTACOMERCIAL-NUMBER-IN' => '',
                    'POBSCLIENTE-VARCHAR2-IN' => '',
                    'PQTDDEPENDENTES-NUMBER-IN' => '',
                    'PRG-VARCHAR2-IN' => '',
                    'PTEL-VARCHAR2-IN' => '',
                    'PTELCOBRANCA-VARCHAR2-IN' => '',
                    'PTIPOLOGRADOURO-VARCHAR2-IN' => '',
                    'PTIPOLOGRADOUROCOBRANCA-VARCHAR2-IN' => '',
                    'PVLRLIMITECOMPRA-NUMBER-IN' => '',
                    'PVLRLIMITECREDITO-NUMBER-IN' => '',
                    'PMSG-VARCHAR2-OUT' => ''
                ]
            ]);

            $customerId = $this->parseResponse($response);

            dd($customerId);

            return trim($customerId);

        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function parseResponse($response, $includeRoot = false)
    {
        return (string) $response->PMSG;
    }

}