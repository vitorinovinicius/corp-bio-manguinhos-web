<?php

    namespace App\Criteria;

    use Prettus\Repository\Contracts\CriteriaInterface;
    use Prettus\Repository\Contracts\RepositoryInterface;
    use Request;

    /**
     * Class ProductCriteria.
     *
     * @package namespace App\Criteria;
     */
    class ProductCriteria implements CriteriaInterface
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
            $model = $model
//                ->with('contractor', 'categories')
                ->selectRaw('products.*');

            $id = Request::get('id');
            if (isset($id) && !empty($id)) {
                $model->where('products.id', '=', $id);
            }

            $name = Request::get('name');
            if (isset($name) && !empty($name)) {
                $model->where('products.name', 'LIKE', '%' . $name . '%');
            }

            $description = Request::get('description');
            if (isset($description) && !empty($description)) {
                $model->where('products.description', 'LIKE', '%' . $description . '%');
            }

            $value = Request::get('value');
            if (isset($value) && !empty($value)) {
                $model->where('products.value', '=', $value);
            }

            $amount = Request::get('amount');
            if (isset($amount) && !empty($amount)) {
                $model->where('products.amount', '=', $amount);
            }

            $status = Request::get('status');
            if (isset($status) && !empty($status)) {
                $model->where('products.status', '=', $status);
            }

            return $model;
            return $model;
        }
    }
