<?php

    namespace App\Criteria;

    use Illuminate\Support\Facades\Request;
    use Prettus\Repository\Contracts\CriteriaInterface;
    use Prettus\Repository\Contracts\RepositoryInterface;

    /**
     * Class FinancialListCriteria.
     *
     * @package namespace App\Criteria;
     */
    class FinancialListCriteria implements CriteriaInterface
    {
        /**
         * Apply criteria in query repository
         *
         * @param string $model
         * @param RepositoryInterface $repository
         *
         * @return mixed
         */
        public function apply($model, RepositoryInterface $repository)
        {
            $model = $model->selectRaw('financials.*');
            $model = $model->join('occurrences', 'financials.occurrence_id', '=', 'occurrences.id');

            if (\Auth::user()->contractor_id) {
                $model = $model->where('occurrences.contractor_id', \Auth::user()->contractor_id); //Para não aparecer nada
            }

            //Pega os filtros
            $id = Request::get('id');
            if (isset($id) && !empty($id)) {
                $model->where('occurrences.id', '=', $id);
            }

            $numero_os = Request::get('numero_os');
            if (isset($numero_os) && !empty($numero_os)) {
                if (strstr($numero_os, ",")) {
                    //                $clientList = explode(",", str_replace(" ", "", trim($numero_os)));
                    $clientList = preg_split("/(,| )/", trim($numero_os));
                    $model->whereIn('occurrences.numero_os', $clientList);
                } else {
                    $aListClient = [];

                    $clientList = preg_split('/\s+/', $numero_os);

                    foreach ($clientList as $client) {
                        $aListClient[] = trim($client);
                    }
                    $model->whereIn('occurrences.numero_os', $clientList);
                }
            }

            $status = Request::get('status');
            if (isset($status) && $status != "") {
                $model->where('financials.status', '=', $status);
            }

            $model->orderBy("updated_at", "DESC");

            return $model;
        }
    }
