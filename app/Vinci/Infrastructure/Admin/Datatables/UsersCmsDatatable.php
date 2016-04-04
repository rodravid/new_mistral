<?php

namespace Vinci\Infrastructure\Admin\Datatables;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Vinci\Domain\Admin\AdminRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class UsersCmsDatatable extends AbstractDatatables
{

    protected $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function getData($perPage, $start, array $order = null, array $search = null)
    {
        $qb = $this->adminRepository->createQueryBuilder('o')
            ->select('o')
            ->setFirstResult($start)
            ->setMaxResults($perPage);

        if (! empty($search['value'])) {

            $qb->where($qb->expr()->eq('o.id', ':id'));

            $qb->orWhere($qb->expr()->orX(
                $qb->expr()->like('o.name', ':search'),
                $qb->expr()->like('o.email', ':search')
            ));

            $qb->setParameter('id', $search['value']);
            $qb->setParameter('search', '%' . $search['value'] . '%');
        }

        $dir = $order['dir'];

        switch ($order['column']) {

            case 0:
                $qb->orderBy('o.id', $dir);

                break;

            case 1:
                $qb->orderBy('o.name', $dir);
                break;

            case 2:
                $qb->orderBy('o.email', $dir);
                break;

            case 3:
                $qb->orderBy('o.createdAt', $dir);
                break;
        }

        $paginator = new Paginator($qb->getQuery());

        $data = $this->parseDataForDatatable($paginator->getIterator());

        return $this->makeDatatablesOutput($paginator->count(), $data);
    }

    protected function parseDataForDatatable($data)
    {
        $users = [];
        foreach ($data as $user) {
            $users[] = [
                $user->getId(),
                $user->getName(),
                $user->getEmail(),
                $user->getCreatedAt()->format('d/m/Y H:i:s'),
                $this->getActionsLinks($user)
            ];
        }

        return $users;
    }

    protected function getActionsLinks($entity)
    {
        return '<div class="btn-group btn-group-xs">
                    <a href="/cms/users/edit/' . $entity->getId() . '" class="btn btn-default" data-editable><i class="fa fa-edit"></i> Editar</a>
                    <a href="/cms/users/delete/' . $entity->getId() . '" class="btn btn-danger" data-deletable><i class="fa fa-trash"></i> Excluir</a>
                </div>';
    }

}