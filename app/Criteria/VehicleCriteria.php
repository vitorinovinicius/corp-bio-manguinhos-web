<?php

namespace App\Criteria;

use App\Models\Vehicle;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Request;

/**
 * Class VehicleCriteria.
 *
 * @package namespace App\Criteria;
 */
class VehicleCriteria implements CriteriaInterface
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
        $model = $model
//            ->with(['contractor', 'user'])
            ->selectRaw('vehicles.*')
        ;

        $id = Request::get('id');
        if (isset($id) && !empty($id)) {
            $model->where('vehicles.id', '=', $id );
        }

        $contractor = Request::get('contractor_id');
        if (isset($contractor) && !empty($contractor)) {
            $model->where('vehicles.contractor_id', '=' , $contractor);
        }

        $year = Request::get('year');
        if (isset($year) && !empty($year)) {
            $model->where('vehicles.yer', '=' , $year);
        }

        $year = Request::get('year');
        if (isset($year) && !empty($year)) {
            $model->where('vehicles.yer', '=' , $year);
        }

        $document_date = Request::get('document_date');
        if (isset($document_date) && !empty($document_date)) {
            $model->where('vehicles.document_date', '=' , $document_date);
        }

        $due_date = Request::get('due_date');
        if (isset($due_date) && !empty($due_date)) {
            $model->where('vehicles.due_date', '=' , $due_date);
        }

        $placa = Request::get('placa');
        if (isset($placa) && !empty($placa)) {
            $model->where('vehicles.placa', '=' , $placa);
        }

        $chassi = Request::get('chassi');
        if (isset($chassi) && !empty($chassi)) {
            $model->where('vehicles.chassi', '=' , $chassi);
        }

        $brand = Request::get('brand');
        if (isset($brand) && !empty($brand)) {
            $model->where('vehicles.brand', '=' , $brand);
        }


        $modelo = Request::get('model');
        if (isset($modelo) && !empty($modelo)) {
            $model->where('vehicles.model', '=' , $modelo);
        }

        $type = Request::get('type');
        if (isset($type) && !empty($type)) {
            $model->where('vehicles.type', '=' , $type);
        }

        return $model;
    }
}
