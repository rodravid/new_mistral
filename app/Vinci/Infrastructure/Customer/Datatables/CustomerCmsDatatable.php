<?php

namespace Vinci\Infrastructure\Customer\Datatables;

use Vinci\App\Cms\Http\Customer\Presenters\CustomerPresenter;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class CustomerCmsDatatable extends AbstractDatatables
{

    protected $repository;

    public function __construct(ACLService $aclService, CustomerRepository $repository)
    {
        parent::__construct($aclService);

        $this->repository = $repository;
    }

    protected $sortMapping = [
        0 => 'o.id',
        1 => 'o.customerType',
        2 => 'o.name',
        3 => 'o.email',
        4 => 'o.',
        6 => 'o.createdAt',
        7 => 'o.status',
        8 => 'o.erpIntegrationStatus',
    ];

    public function getResultPaginator($perPage, $start, array $order = null, array $search = null)
    {
        $qb = $this->repository->createQueryBuilder('o')
            ->select('o')
            ->setFirstResult($start)
            ->setMaxResults($perPage);

        if (! empty($search['value'])) {

            $qb->where($qb->expr()->eq('o.id', ':id'));

            $qb->orWhere($qb->expr()->orX(
                $qb->expr()->like('o.name', ':search'),
                $qb->expr()->like('o.email', ':search'),
                $qb->expr()->like('o.cpf', ':search'),
                $qb->expr()->like('o.cnpj', ':search')
            ));

            $qb->setParameter('id', $search['value']);
            $qb->setParameter('search', '%' . $search['value'] . '%');
        }

        $this->applyOrder($order, $qb);

        return $this->makePaginator($qb->getQuery());
    }

    public function parseSingleResult($customer)
    {

        $presenter = new CustomerPresenter($customer);

        return [
            $presenter->getId(),
            $presenter->customer_type,
            $presenter->getName(),
            $presenter->getEmail(),
            $presenter->getDocument(),
            $presenter->getRegistry(),
            $presenter->created_at,
            $presenter->status_html,
            $presenter->integration_status_html,
            $this->buildActionsColumn($customer)
        ];
    }

    protected function buildActionsColumn(Model $entity, array $params = [])
    {
        $actions = '<div class="btn-group btn-group-xs">';

        if ($this->checkShowPermission(cmsUser())) {
            $actions .= '<a href="' . route($this->getShowRouteName(), [$entity->getId()]) . '" class="btn btn-info"><i class="fa fa-eye"></i> Visualizar</a>';
        }

        if ($this->checkEditPermission(cmsUser())) {
            $actions .= '<a href="' . route($this->getEditRouteName(), [$entity->getId()]) . '" class="btn btn-primary"><i class="fa fa-edit"></i> Editar</a>';
        }

        if ($this->checkDestroyPermission(cmsUser())) {
            $actions .= '<a href="javascript:void(0);" class="btn btn-danger"
                   data-form-link
                   data-confirm-title="Confirmação de exclusão"
                   data-confirm-text="Deseja realmente excluir esse registro?"
                   data-method="DELETE"
                   data-action="' . route($this->getDestroyRouteName(), [$entity->getId()]) . '"><i class="fa fa-trash"></i> Excluir</a>';
        }

        $actions .= '</div>';

        return $actions;
    }

}