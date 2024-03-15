<?php

    namespace App\Services\Api;

    use App\Repositories\ExpenseTypesRepository;
    use Auth;

    class ExpenseTypeService
    {
        /**
         * @var ExpenseTypesRepository
         */
        private $expenseTypesRepository;

        /**
         * ExpenseTypeService constructor.
         * @param ExpenseTypesRepository $expenseTypesRepository
         */
        public function __construct(ExpenseTypesRepository $expenseTypesRepository)
        {
            $this->expenseTypesRepository = $expenseTypesRepository;
        }

        public function list()
        {
            if (!Auth::guard('api')->check()) {
                return response()->json(["error" => "Erro na autenticacao"], 500);
            }
            if (!Auth::guard('api')->user()->contractor_id) {
                return response()->json(["error" => "Erro na autenticacao"], 500);
            }
            return $this->expenseTypesRepository->findWhere(["contractor_id" => Auth::guard('api')->user()->contractor_id])->all();
        }
    }
