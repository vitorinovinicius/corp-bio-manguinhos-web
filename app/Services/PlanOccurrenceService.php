<?php

    namespace App\Services;

    use App\Criteria\OccurrenceClientSelectCriteria;
    use App\Criteria\OccurrenceTypeCriteria;
    use App\Criteria\OperatorSelectCriteria;
    use App\Criteria\PlanOccurrenceCriteria;
    use App\Repositories\ContractorRepository;
    use App\Repositories\PlanOccurrenceRepository;
    use App\Repositories\OccurrenceTypeRepository;
    use App\Repositories\UserRepository;
    use App\Repositories\OccurrenceClientRepository;

    class PlanOccurrenceService
    {
        private $planOccurrenceRepository;
        private $occurrenceTypeRepository;
        private $userRepository;
        private $occurrenceClientRepository;
        /**
         * @var ContractorRepository
         */
        private $contractorRepository;

        /**
         * PlanOccurrenceService constructor.
         * @param PlanOccurrenceRepository $planOccurrenceRepository
         * @param OccurrenceTypeRepository $occurrenceTypeRepository
         * @param UserRepository $userRepository
         * @param OccurrenceClientRepository $occurrenceClientRepository
         * @param ContractorRepository $contractorRepository
         */
        public function __construct(PlanOccurrenceRepository $planOccurrenceRepository, OccurrenceTypeRepository $occurrenceTypeRepository, UserRepository $userRepository, OccurrenceClientRepository $occurrenceClientRepository, ContractorRepository $contractorRepository)
        {
            $this->planOccurrenceRepository = $planOccurrenceRepository;
            $this->occurrenceTypeRepository = $occurrenceTypeRepository;
            $this->userRepository = $userRepository;
            $this->occurrenceClientRepository = $occurrenceClientRepository;
            $this->contractorRepository = $contractorRepository;
        }

        public function listPlanOccurrences()
        {
            $planOccurrences = $this->planOccurrenceRepository->pushCriteria(new PlanOccurrenceCriteria())->all();
            $occurrenceTypes = $this->occurrenceTypeRepository->pushCriteria(new OccurrenceTypeCriteria())->all();
            $operators = $this->userRepository->pushCriteria(new OperatorSelectCriteria())->all();

            return view('plan_occurrences.index', compact('planOccurrences', 'occurrenceTypes', 'operators'));
        }

        public function createPlanOccurrences()
        {
            if (!\Auth::user()->contractor_id) {
                return redirect()->route('plan_occurrences.index')->with('error', "Apenas empresas têm acesso a criar o item.");
            }

            $occurrenceTypes = $this->occurrenceTypeRepository->pushCriteria(new OccurrenceTypeCriteria())->all();
            $operators = $this->userRepository->pushCriteria(new OperatorSelectCriteria())->all();
            $occurrenceClients = $this->occurrenceClientRepository->pushCriteria(new OccurrenceClientSelectCriteria())->all();

            $contractors = $this->contractorRepository->all();

            return view('plan_occurrences.create', compact('occurrenceTypes', 'operators', 'occurrenceClients', 'contractors'));
        }

        public function storePlanOccurrence($request)
        {
            if (!\Auth::user()->contractor_id) {
                return redirect()->route('plan_occurrences.index')->with('error', "Apenas empresas têm acesso a criar o item.");
            }

            $data = $request->all();

            try {
                $this->planOccurrenceRepository->create($data);
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: ' . $e->getMessage());
            }

            return redirect()->route('plan_occurrences.index')->with('message', 'Item criado com sucesso.');

        }

        public function showPlanOccurrence($planOccurrence)
        {
            return view('plan_occurrences.show', compact('planOccurrence'));
        }

        public function editPlanOccurrence($planOccurrence)
        {
            $occurrenceTypes = $this->occurrenceTypeRepository->pushCriteria(new OccurrenceTypeCriteria())->all();
            $operators = $this->userRepository->pushCriteria(new OperatorSelectCriteria())->all();
            $occurrenceClients = $this->occurrenceClientRepository->pushCriteria(new OccurrenceClientSelectCriteria())->all();

            $contractors = $this->contractorRepository->all();
            return view('plan_occurrences.edit', compact('planOccurrence', 'occurrenceTypes', 'operators', 'occurrenceClients', 'contractors'));
        }

        public function updatePlanOccurrence($request, $planOccurrence)
        {
            $data = $request->all();

            if (!$request->input("weekend")) {
                $data["weekend"] = 0;
            }

            try {
                $this->planOccurrenceRepository->update($data, $planOccurrence->id);
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Erro ao tentar atualizar o item. <br>Erro: ' . $e->getMessage());
            }

            return redirect()->route('plan_occurrences.show', $planOccurrence->uuid)->with('message', 'Item atualizado com sucesso.');

        }

        public function destroyPlanOccurrence($planOccurrence)
        {
            $this->planOccurrenceRepository->delete($planOccurrence->id);

            return redirect()->route('plan_occurrences.index')->with('message', 'Item excluído com sucesso.');
        }
    }
