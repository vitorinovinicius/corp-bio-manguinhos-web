<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class EnvioEmailCriteria.
 *
 * @package namespace App\Criteria;
 */
class EnvioEmailCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model
            ->selectRaw('secao_formularios.*')->with('usuario');

        return $model;
    }
}
