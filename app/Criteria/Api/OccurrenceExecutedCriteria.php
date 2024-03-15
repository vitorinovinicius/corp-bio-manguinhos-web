<?php

namespace App\Criteria\Api;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceOpenedApiCriteria
 * @package namespace App\Criteria;
 */
class OccurrenceExecutedCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model
            ->with(['occurrence_types','occurrence_clients'])
            ->where('operator_id',$this->user_id)
            ->where('open_close', false)
//            ->where('realized', true)
        ;

        return $model;
    }
}
