<?php

    namespace App\Criteria;

    use Illuminate\Support\Facades\Request;
    use Prettus\Repository\Contracts\CriteriaInterface;
    use Prettus\Repository\Contracts\RepositoryInterface;

    /**
     * Class InterferenceClientCriteria.
     *
     * @package namespace App\Criteria;
     */
    class InterferenceClientCriteria implements CriteriaInterface
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
            $model = $model->selectRaw('occurrence_clients.*');

            $model->whereHas('occurrences', function ($query) {
                $query->whereHas('interferences', function ($query) {
                    $interference = Request::get('interference_id');
                    if (isset($interference) && !empty($interference)) {
                        $query->where('interferences.id', '=', $interference);
                    }
                    if ($interference != 1) {
                        $query->where('interferences.id', '<>', 1); //Sem anomalias
                    }
                });

                $schedule_date = Request::get('schedule_date');
                if (isset($schedule_date) && !empty($schedule_date)) {
                    $schedule_date = format_range_to_database($schedule_date);
                    $query->whereBetween('occurrences.schedule_date', [
                        $schedule_date[0],
                        $schedule_date[1]
                    ]);
                }
            });

            $id = Request::get('id');
            if (isset($id) && !empty($id)) {
                $model = $model->where('occurrence_clients.id', '=', $id);
            }

            $email = Request::get('email');
            if (isset($email) && !empty($email)) {
                $model = $model->where('occurrence_clients.email', 'LIKE', $email . '%');
            }

            $cpf = Request::get('cpf');
            if (isset($cpf) && !empty($cpf)) {
                $model = $model->where('occurrence_clients.cpf', '=', $cpf);
            }

            $client_number = Request::get('client_number');
            if (isset($client_number) && !empty($client_number)) {
                $model = $model->where('occurrence_clients.client_number', '=', $client_number);
            }

            $name = Request::get('name');
            if (isset($name) && !empty($name)) {
                $model = $model->where('occurrence_clients.name', 'LIKE', '%' . $name . '%');
            }

            $address = Request::get('address');
            if (isset($address) && !empty($address)) {
                $model = $model->Where('occurrence_clients.address', 'LIKE', '%' . $address . '%');
            }
            $district = Request::get('district');
            if (isset($district) && !empty($district)) {
                $model = $model->Where('occurrence_clients.district', 'LIKE', '%' . $district . '%');
            }
            $city = Request::get('city');
            if (isset($city) && !empty($city)) {
                $model = $model->Where('occurrence_clients.city', 'LIKE', '%' . $city . '%');
            }
            $uf = Request::get('uf');
            if (isset($uf) && !empty($uf)) {
                $model = $model->where('occurrence_clients.uf', '=', $uf);
            }

            $search = Request::get('search');
            if (isset($search) && !empty($search)) {
                if (is_numeric($search)) {
                    $model = $model->where('occurrence_clients.client_number', '=', $search);
                } else {
                    $model = $model->where('occurrence_clients.name', 'like', $search . '%');
                }
            }

            $model->orderBy("occurrence_clients.id", "DESC");

            return $model;

        }
    }
