<?php
/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 2/27/16
 * Time: 11:25 AM
 */

namespace Vinci\Infrastructure\Users\Criteria;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class AdminCriteria implements CriteriaInterface
{

    /**
     * Apply criteria in query repository
     *
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->with('profile')->has('profile');
    }

}