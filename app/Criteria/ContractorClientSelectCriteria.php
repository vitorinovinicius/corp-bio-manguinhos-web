<?php

namespace App\Criteria;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ContractorClientSelectCriteria.
 *
 * @package namespace App\Criteria;
 */
class ContractorClientSelectCriteria implements CriteriaInterface
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

        $model = $model->selectRaw('occurrence_clients.*');

        $model->where('occurrence_clients.status', '=', 1);

        $model->where('occurrence_clients.type_client', '=', 1);

        $id = Request::get('id');
        if(isset($id) && !empty($id)){
            $model->where('occurrence_clients.id', '=', $id);
        }

        $email = Request::get('email');
        if(isset($email) && !empty($email)){
            $model->where('occurrence_clients.email','LIKE',$email.'%');
        }

        $cpf = Request::get('cpf');
        if(isset($cpf) && !empty($cpf)){
            $model->where('occurrence_clients.cpf', '=', $cpf);
        }

        $client_number = Request::get('client_number');
        if(isset($client_number) && !empty($client_number)){
            $model->where('occurrence_clients.client_number', '=', $client_number);
        }

        $name = Request::get('name');
        if(isset($name) && !empty($name)){
            $model->where('occurrence_clients.name','LIKE','%'.$name.'%');
        }

        $address = Request::get('address');
        if(isset($address) && !empty($address)){
            $model->Where('address','LIKE','%'.$address.'%');
        }
        $district = Request::get('district');
        if(isset($district) && !empty($district)){
            $model->Where('district','LIKE','%'.$district.'%');
        }
        $city = Request::get('city');
        if(isset($city) && !empty($city)){
            $model->Where('city','LIKE','%'.$city.'%');
        }
        $uf = Request::get('uf');
        if(isset($uf) && !empty($uf)){
            $model->where('occurrence_clients.uf', '=', $uf);
        }


        $search = Request::get('search');
        if(isset($search) && !empty($search)){
            if(is_numeric($search)){
                $model->where('occurrence_clients.client_number', '=', $search);
            }else{
                $model->where('occurrence_clients.name', 'like', $search.'%');
            }
        }

        $contractor_id = Request::get('contractor_id');
        if (isset($contractor_id) && !empty($contractor_id)) {
            if($contractor_id == "x"){
                $model->whereDoesntHave('occurrences');
            } else {
                $model->where('occurrences.contractor_id', '=', $contractor_id);
            }
        }

        $check_schedule_date = Request::get('check_schedule_date');
        if(isset($check_schedule_date) && !empty($check_schedule_date)){

            $model->where('occurrences.schedule_date', '<', Carbon::today());
        }

        if($contractor_id || $check_schedule_date){
            $model->join('occurrences','occurrence_clients.id', '=', 'occurrences.occurrence_client_id');
        }

        $model->orderBy("occurrence_clients.id","DESC");

        return $model;
    }
}
