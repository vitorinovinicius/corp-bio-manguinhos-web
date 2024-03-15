<?php

namespace App\Criteria;

use Artesaos\Defender\Facades\Defender;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceSelectCriteria
 * @package namespace App\Criteria;
 */
class LogImportErrorSelectCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
           return $model;
    }
}
