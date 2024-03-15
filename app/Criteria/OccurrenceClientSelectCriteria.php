<?php

namespace App\Criteria;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceClientSelectCriteria
 * @package namespace App\Criteria;
 */
class OccurrenceClientSelectCriteria implements CriteriaInterface
{
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

        $model = $model->where('status', '=', 1);

        $id = Request::get('id');
        if(isset($id) && !empty($id)){
            $model = $model->where('id', '=', $id);
        }

        $email = Request::get('email');
        if(isset($email) && !empty($email)){
            $model = $model->where('email','LIKE',$email.'%');
        }

        $cpf = Request::get('cpf_cnpj');
        if(isset($cpf) && !empty($cpf)){
            $model = $model->where('cpf_cnpj', '=', $cpf);
        }

        $client_number = Request::get('client_number');
        if(isset($client_number) && !empty($client_number)){
            $model = $model->where('client_number', '=', $client_number);
        }

        $name = Request::get('name');
        if(isset($name) && !empty($name)){
            $model = $model->where('name','LIKE','%'.$name.'%');
        }

        $address = Request::get('address');
        if(isset($address) && !empty($address)){
            $model = $model->Where('address','LIKE','%'.$address.'%');
        }
        $district = Request::get('district');
        if(isset($district) && !empty($district)){
            $model = $model->Where('district','LIKE','%'.$district.'%');
        }
        $city = Request::get('city');
        if(isset($city) && !empty($city)){
            $model = $model->Where('city','LIKE','%'.$city.'%');
        }
        $uf = Request::get('uf');
        if(isset($uf) && !empty($uf)){
            $model = $model->where('uf', '=', $uf);
        }

        $search = Request::get('search');
        if(isset($search) && !empty($search)){
            if(is_numeric($search)){
                $model = $model->where('client_number', '=', $search)->orWhere('id', '=', $search);
            }else{
                $model = $model->where('name', 'like', $search.'%');
            }
        }

        $model->orderBy("id","DESC");

        return $model;
    }
}
