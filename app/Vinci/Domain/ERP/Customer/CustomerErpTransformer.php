<?php

namespace Vinci\Domain\ERP\Customer;

use Vinci\Domain\ERP\Transformer\BaseTransformer;

class CustomerErpTransformer extends BaseTransformer
{

    public function transform(Customer $customer)
    {
        return [
            'PAPELIDO-VARCHAR2-IN' => $customer->document,
            'PAPELIDOFILIALPADRAO-VARCHAR2-IN' => '',
            'PBAIRRO-VARCHAR2-IN' => $customer->address->district,
            'PBAIRROCOBRANCA-VARCHAR2-IN' => $customer->billing_address->district,
            'PCAIXAPOSTAL-VARCHAR2-IN' => '',
            'PCAIXAPOSTALCOBRANCA-VARCHAR2-IN' => '',
            'PCEP-VARCHAR2-IN' => $customer->address->postal_code,
            'PCEPCAIXAPOSTAL-VARCHAR2-IN' => '',
            'PCEPCOBRANCA-VARCHAR2-IN' => $customer->billing_address->postal_code,
            'PCGC-VARCHAR2-IN' => $customer->cnpj,
            'PCODCENTROCUSTOPADRAO-NUMBER-IN' => '',
            'PCODCLASSIFCLIENTE-VARCHAR2-IN' => 'CONS',
            'PCODCLASSIFPESSOA-VARCHAR2-IN' => 'CNS',
            'PCODCLASSIFPESSOAFISICA-VARCHAR2-IN' => $customer->person_code,
            'PCODCLASSIFPESSOAJURIDICA-VARCHAR2-IN' => 'E',
            'PCODCONDICAOPAGTOPADRAO-VARCHAR2-IN' => '',
            'PCODCONDICAOPAGTOPADRAOCLI-VARCHAR2-IN' => '',
            'PCODCONDICAOPGTOPADRAOFORN-VARCHAR2-IN' => '',
            'PCODCONTACONTABILPADRAO-VARCHAR2-IN' => '',
            'PCODGRUPOCONTABILPADRAO-VARCHAR2-IN' => '',
            'PCODIBGEMUN-NUMBER-IN' => $customer->address->city_code,
            'PCODIBGEMUNCOB-NUMBER-IN' => $customer->billing_address->city_code,
            'PCODIBGEPAIS-NUMBER-IN' => $customer->address->country_code,
            'PCODIBGEPAISCOB-NUMBER-IN' => $customer->billing_address->country_code,
            'PCODIBGEUF-NUMBER-IN' => $customer->address->state_code,
            'PCODIBGEUFCOB-NUMBER-IN' => $customer->billing_address->state_code,
            'PCODLIQDCFINANCPADRAO-VARCHAR2-IN' => '',
            'PCODPRODUTOSERVICOPADRAO-VARCHAR2-IN' => '',
            'PCODPRODUTOSERVICOPADRAOCLI-VARCHAR2-IN' => '',
            'PCODPROJETOPADRAOCLIENTE-VARCHAR2-IN' => '',
            'PCODPROJETOPADRAOFORNCD-VARCHAR2-IN' => '',
            'PCODREGIAO-VARCHAR2-IN' => '',
            'PCODSITCLIENTE-NUMBER-IN' => 1,
            'PCODTIPOOCUPACAO-VARCHAR2-IN' => '',
            'PCODTIPOPESSOA-VARCHAR2-IN' => $customer->person_type,
            'PCODUNIDADENEGOCIO-VARCHAR2-IN' => '',
            'PCOMPLEMENTOENDER-VARCHAR2-IN' => $customer->address->complement,
            'PCOMPLEMENTOENDERCOBRANCA-VARCHAR2-IN' => $customer->billing_address->complement,
            'PCONTATO-VARCHAR2-IN' => $customer->contact_name,
            'PCPF-VARCHAR2-IN' => $customer->cpf,
            'PDDD-NUMBER-IN' => $customer->phone->ddd,
            'PDDDCOBRANCA-NUMBER-IN' => $customer->phone->ddd,
            'PDDDFAX-NUMBER-IN' => $customer->cell_phone->ddd,
            'PDTCADASTRO-DATE-IN' => '',
            'PDTREGJUNTACOMERCIAL-DATE-IN' => '',
            'PEMAIL-VARCHAR2-IN' => $customer->email,
            'PEMAILNF-VARCHAR2-IN' => $customer->email,
            'PENDER-VARCHAR2-IN' => $customer->address->address,
            'PENDERCOBRANCA-VARCHAR2-IN' => $customer->billing_address->address,
            'PFAX-VARCHAR2-IN' => $customer->cell_phone->number,
            'PFPAS-NUMBER-IN' => 0,
            'PIDPESSOA-VARCHAR2-IN' => $customer->document,
            'PINDATIVA-VARCHAR2-IN' => 'S',
            'PINDCALCULOIRRFBAIXO-VARCHAR2-IN' => '',
            'PINDCLIENTE-VARCHAR2-IN' => 'S',
            'PINDDEDUCAODEPENDENTEIRRF-VARCHAR2-IN' => '',
            'PINDDISPENSACALCULOINSSRET-VARCHAR2-IN' => '',
            'PINDDISPENSARECOLINSS-VARCHAR2-IN' => '',
            'PINDFORNCD-VARCHAR2-IN' => '',
            'PINSCRESTADUAL-VARCHAR2-IN' => '',
            'PINSCRESTADUALFIS-VARCHAR2-IN' => '',
            'PINSCRIMUNIC-VARCHAR2-IN' => '',
            'PNOME-VARCHAR2-IN' => $customer->name,
            'PNUMAGENCIACCPADRAO-VARCHAR2-IN' => '',
            'PNUMBACENCCPADRAO-VARCHAR2-IN' => '',
            'PNUMBACENPADRAO-VARCHAR2-IN' => '',
            'PNUMCCPADRAO-VARCHAR2-IN' => '',
            'PNUMCLASSESALARIOBASE-NUMBER-IN' => '',
            'PNUMENDER-VARCHAR2-IN' => $customer->address->number,
            'PNUMENDERCOBRANCA-VARCHAR2-IN' => $customer->billing_address->number,
            'PNUMINSCRINSS-VARCHAR2-IN' => '',
            'PNUMPISPASEPCI-NUMBER-IN' => '',
            'PNUMREGJUNTACOMERCIAL-NUMBER-IN' => '',
            'POBSCLIENTE-VARCHAR2-IN' => $customer->obs,
            'PQTDDEPENDENTES-NUMBER-IN' => 0,
            'PRG-VARCHAR2-IN' => $customer->rg,
            'PTEL-VARCHAR2-IN' => $customer->phone->number,
            'PTELCOBRANCA-VARCHAR2-IN' => $customer->phone->number,
            'PTIPOLOGRADOURO-VARCHAR2-IN' => $customer->address->public_place,
            'PTIPOLOGRADOUROCOBRANCA-VARCHAR2-IN' => $customer->billing_address->public_place,
            'PVLRLIMITECOMPRA-NUMBER-IN' => '',
            'PVLRLIMITECREDITO-NUMBER-IN' => '',
            'PMSG-VARCHAR2-OUT' => ''
        ];
    }

}