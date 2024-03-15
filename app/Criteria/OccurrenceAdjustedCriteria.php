<?php

namespace App\Criteria;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceAdjustedCriteria.
 *
 * @package namespace App\Criteria;
 */
class OccurrenceAdjustedCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
//        $model = $model->selectRaw('occurrences.*, SUM(uniao.valor_total) AS soma');
        $model = $model->selectRaw('occurrences.*');
        $city           = Request::get('city');
        $district       = Request::get('district');
        $address        = Request::get('address');
        $client_number  = Request::get('client_number');
        $search         = Request::get('search');

        if(
            (isset($city) && !empty($city)) OR
            (isset($district) && !empty($district)) OR
            (isset($address) && !empty($address)) OR
            (isset($client_number) && !empty($client_number)) OR
            (isset($search) && !empty($search))
        ){
            $model = $model->join('occurrence_clients', 'occurrences.occurrence_client_id', '=' ,'occurrence_clients.id');
        }

        $model = $model->where("occurrences.status","=",2); // realizado
        $model = $model->where("occurrences.approved","=",4); // liberadas

        //Pega os filtros
        criteriaSearch($model);

        $model->groupBy('occurrences.id');

//        $model->havingRaw('SUM(uniao.valor_total) > 500');

        $model->orderBy("occurrences.check_out","DESC");

        return $model;
    }
}
