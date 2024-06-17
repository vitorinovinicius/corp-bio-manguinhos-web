<?php

namespace App\Services;


use App\Criteria\TeamSelectCriteria;
use App\Models\Occurrence;
use App\Models\User;
use App\Models\Setor;
use App\Repositories\TeamRepository;
use Carbon\Carbon;
use App\Repositories\OccurrenceRepository;
use App\Criteria\OccurrenceSelectCriteria;

class TeamService
{
    /**
     * @var TeamRepository
     */
    private $teamRepository;

    /**
     * occurrenceRepository
     *
     * @var mixed
     */
    private $occurrenceRepository;

    public function __construct(TeamRepository $teamRepository, OccurrenceRepository $occurrenceRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->occurrenceRepository = $occurrenceRepository;
    }

    public function addNewTeam($teamRequest)
    {
        // if (!\Auth::user()->contractor_id) {
        //     return redirect()->route('teams.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        // }

        $data = $teamRequest->all();
        $supervisor = User::find($data['supervisor_id']);

        if(!$supervisor->hasRole("supervisor")){
            return redirect()->route('teams.index')->withInput()->with('error', 'Erro ao verificar se o supervisor tem autorização.');
        }


        $team = $this->teamRepository->create($data);

        $dataFinal[$data['supervisor_id']] = ['is_supervisor' => true];

        $team->users()->attach($dataFinal);

        return redirect()->route('teams.index')->with('message', 'Item criado com sucesso.');

    }

    public function editTeam($request, $team)
    {

        $data = $request->all();

        $supervisor = User::find($data['supervisor_id']);

        if(!$supervisor->hasRole("supervisor")){
            return false;
        }

        $this->teamRepository->update($data, $team->id);

        $supervisorAtual = $team->users()->wherePivot('is_supervisor', 1)->first();

        if($supervisorAtual) {
            $team->users()->detach([$supervisorAtual->id]);
        }

        $dataFinal[$data['supervisor_id']] = ['is_supervisor' => true];

        $team->users()->attach($dataFinal);
    }

    public function listTeams()
    {
        $teams = Setor::all();

        return $teams->paginate();
    }

    public function deleteTeam($team)
    {
        //Verifica se o usuário pertence a alguma equipe
        if(count($team->users()->wherePivot('is_supervisor',0)->get()) > 0){
            return redirect()->route('teams.index')->with('error', 'O item '.$team->name.' não pode ser deletada pois ainda têm operadores associados.');
        }else{
            $team->users()->detach([$team->users[0]->id]);
            $team->delete();
            return redirect()->route('teams.index')->with('message', 'Equipe '.$team->name.' deletada com sucesso.');
        }
    }

    public function showTeam($team)
    {

        $date = \Request::get('schedule_date') ? \Request::get('schedule_date') : Carbon::now()->format('Y-m-d');
        $operators = $team->users;
        $data = [];
        $dados = [];

        $occurrences = $this->occurrenceRepository->where([
            'schedule_date' => $date,
            'operator_id' => null,
        ]);

        $occurrenceType = \Request::get('occurrence_type_id');
        if(isset($occurrenceType) && !empty($occurrenceType)){
            $occurrences->where('occurrence_type_id', '=', $occurrenceType);
        }
        $occurrences = $occurrences->get();

        foreach($occurrences as $occurrence){
            $dateFormat = ($occurrence->schedule_time != null) ? $occurrence->schedule_time :  '7:00';
            $dados[] = [
                'start'=> dataAgendamentoFormartJS($occurrence->schedule_date, $dateFormat, $occurrence->shift),
                'end'=> dataAgendamentoFormartJSLimite($occurrence->average_time, $dateFormat, $occurrence->schedule_date, $occurrence->shift),
                'text'=>  $occurrence->occurrence_type ? $occurrence->occurrence_type->name : '---',
                'data' => [
                    'occurrence_id'=>$occurrence->id,
                    'operator_id'=>null,
                ]
            ];
            $data[1] = [
                'title' => 'Não atribuídas',
                'operator_id' => null,
                'schedule' => $dados
            ];
        }

        foreach($operators as $operator){
            $dados = [];
            $operator_Occurrences = $operator->occurrences->where('schedule_date', $date);

            if(isset($occurrenceType) && !empty($occurrenceType)){
                $operator_Occurrences = $operator_Occurrences->where('occurrence_type_id', '=', $occurrenceType);
            }

            if($operator_Occurrences){
                foreach($operator_Occurrences as $occurrence){
                    $dados[] = [
                        'start'=> dataAgendamentoFormartJS($occurrence->schedule_date, $occurrence->schedule_time, $occurrence->shift),
                        'end'=> dataAgendamentoFormartJSLimite($occurrence->average_time, $occurrence->schedule_time, $occurrence->schedule_date, $occurrence->shift),
                        'text'=>  $occurrence->occurrence_type ? $occurrence->occurrence_type->name : '---',
                        'data' => [
                            'occurrence_id'=>$occurrence->id,
                            'operator_id'=>$operator->id,
//                            'class'=> $occurrence->statusLabel(),
                            'class'=> occurrenceStatusBgColor($occurrence->status),
                        ]
                    ];
                }
            }
            $data[$operator->id] = [
                'title' => $operator->name,
                'operator_id' => $operator->id,
                'schedule' => $dados,
                'data' => [
                    'class' => 'table'
                ]
            ];
        }

        $dataString = (json_encode($data, JSON_UNESCAPED_UNICODE ));
        return view('teams.show', compact('team', 'dataString'));
    }

}
