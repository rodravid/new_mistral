<?php

namespace Vinci\Infrastructure\Country\Datatables;

use Vinci\App\Cms\Http\Country\Presenters\CountryPresenter;
use Vinci\Domain\Country\CountryRepository;
use Vinci\Infrastructure\Datatables\AbstractDatatables;

class CountryCmsDatatable extends AbstractDatatables
{

    protected $repository;

    public function __construct(CountryRepository $repository)
    {
        $this->repository = $repository;
    }

    protected $sortMapping = [
        0 => 'o.id',
        2 => 'o.name',
        3 => 'o.createdAt',
        4 => 'o.visibleSite',
        5 => 'o.status'
    ];

    public function getResultPaginator($perPage, $start, array $order = null, array $search = null)
    {
        $qb = $this->repository->createQueryBuilder('o')
            ->leftJoin('o.user', 'u')
            ->leftJoin('o.images', 'i')
            ->setFirstResult($start)
            ->setMaxResults($perPage);

        if (! empty($search['value'])) {

            $qb->where($qb->expr()->eq('o.id', ':id'));

            $qb->orWhere($qb->expr()->orX(
                $qb->expr()->like('o.name', ':search')
            ));

            $qb->setParameter('id', $search['value']);
            $qb->setParameter('search', '%' . $search['value'] . '%');
        }

        $this->applyOrder($order, $qb);

        return $this->makePaginator($qb->getQuery());
    }

    public function parseSingleResult($country)
    {

        $presenter = new CountryPresenter($country);

        return [
            $presenter->getId(),
            $presenter->image_html,
            $presenter->getName(),
            $presenter->created_at,
            $presenter->visible_site,
            $presenter->status_html,
            $this->buildActionsColumn([
                'edit_url' => route('cms.countries.edit', $country->getId()),
                'destroy_url' => route('cms.countries.destroy', $country->getId())
            ])
        ];
    }

}