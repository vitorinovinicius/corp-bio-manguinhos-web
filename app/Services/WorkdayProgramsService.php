<?php

    namespace App\Services;

    use App\Criteria\WorkdayProgramsCriteria;
    use App\Criteria\WorkdaySelectCriteria;
    use App\Repositories\WorkdayProgramsRepository;
    use App\Repositories\WorkdayRepository;

    class WorkdayProgramsService
    {
        private $workdayProgramsRepository;
        private $workdayRepository;

        public function __construct(WorkdayProgramsRepository $workdayProgramsRepository, WorkdayRepository $workdayRepository)
        {
            $this->workdayProgramsRepository = $workdayProgramsRepository;
            $this->workdayRepository = $workdayRepository;
        }

        public function list()
        {
            $workdayPrograms = $this->workdayProgramsRepository->pushCriteria(new WorkdayProgramsCriteria())->all();
            $workdays = $this->workdayRepository->pushCriteria(new WorkdaySelectCriteria())->all();
            // dd($workdayPrograms);
            return view('workday_programs.index', compact('workdayPrograms', 'workdays'));
        }

        public function create()
        {
            $workdays = $this->workdayRepository->pushCriteria(new WorkdaySelectCriteria())->all();
            return view('workday_programs.create', compact('workdays'));
        }

        public function store($request)
        {
            $week = $request->get('week');

            try {
                foreach ($week as $day => $hour) {
                    if ($hour != null) {
                        $data['workday_id'] = $request->get('workday_id');
                        $data['day'] = $day;
                        $data['hour'] = $hour;

                        $this->workdayProgramsRepository->create($data);
                    }
                }
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o(s) item(s). <br>Erro: ' . $e->getMessage());
            }

            return redirect()->route('workday_programs.index')->with('message', "Item(s) criado(s) com sucesso.");
        }

        public function show($workdayPrograms)
        {
            return view('workday_programs.show', compact('workdayPrograms'));
        }

        public function edit($workdayPrograms)
        {
            return view('workday_programs.edit', compact('workdayPrograms'));
        }

        public function update($request, $workdayPrograms)
        {
            $data = $request->all();

            try {
                $this->workdayProgramsRepository->update($data, $workdayPrograms->id);
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Erro ao tentar atualizar o item. <br>Erro: ' . $e->getMessage());
            }

            return redirect()->route('workday_programs.index')->with('message', "Item atualizado com sucesso.");

        }

        public function destroy($workdayPrograms)
        {
            try {
                $this->workdayProgramsRepository->delete($workdayPrograms->id);
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Erro ao tentar exluir o item. <br>Erro: ' . $e->getMessage());
            }

            return redirect()->route('workday_programs.index')->with('message', "Item excluido com sucesso.");
        }
    }
