<?php

namespace App\Services;

use App\Criteria\WorkdaySelectCriteria;
use App\Repositories\WorkdayRepository;
use App\Repositories\WorkdayProgramsRepository;
use Exception;
use Carbon\Carbon;

class WorkdayService
{
    private $workdayRepository;
    private $workdayProgramsRepository;

    public function __construct(WorkdayRepository $workdayRepository, WorkdayProgramsRepository $workdayProgramsRepository)
    {
        $this->workdayRepository = $workdayRepository;
        $this->workdayProgramsRepository = $workdayProgramsRepository;
    }

    public function listWorkday()
    {
        $workdays = $this->workdayRepository->pushCriteria(new WorkdaySelectCriteria())->all();
        return view('workdays.index', compact('workdays'));
    }

    public function createWorkday()
    {
        if (!\Auth::user()->contractor_id) {
            return redirect()->route('workday.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        }

        $days_week = [
            "1" => ["name" => "Domingo","name_min" => "dom"],
            "2" => ["name" => "Segunda-feira","name_min" => "seg"],
            "3" => ["name" => "Terça-feira","name_min" => "ter"],
            "4" => ["name" => "Quarta-feira","name_min" => "qua"],
            "5" => ["name" => "Quinta-feira","name_min" => "qui"],
            "6" => ["name" => "Sexta-feira","name_min" => "sex"],
            "7" => ["name" => "Sábado","name_min" => "sab"],
        ];

        return view('workdays.create',compact("days_week"));
    }

    public function storeWorkday($request)
    {
        if (!\Auth::user()->contractor_id) {
            return redirect()->route('workday.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        }

        $data = $request->all();

        try{

            $workday = $this->workdayRepository->create($data);

            foreach ($data['week'] as $day => $data) {

                $totalHour = Carbon::createFromTime(0, 0, 0);
                foreach($data as $key => $hour){
                   if($hour){

                       $totalHour = Carbon::parse($totalHour)->diff((Carbon::parse($hour)))->format('%H:%I:%S');
                   }
                }
                $data['workday_id'] = $workday->id;
                $data['day'] = $day;
                if($totalHour){
                    $data['hour'] = Carbon::parse($totalHour);
                }

               $this->workdayProgramsRepository->create($data);
            }
        }catch(Exception $e){
            return $e->getMessage();
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('workday.index')->with('message', "Item criado com sucesso.");
    }

    public function showWorkday($workday)
    {
        return view('workdays.show', compact('workday'));
    }

    public function editWorkday($workday)
    {
        // dd($workday->workday_programs);
        return view('workdays.edit', compact('workday'));
    }

    public function updateWorkday($request, $workday)
    {
        $data = $request->all();

        try{
            $this->workdayRepository->update($data, $workday->id);
            $this->workdayProgramsRepository->where('workday_id', '=', $workday->id)->delete();


            foreach ($data['week'] as $day => $data) {

                $totalHour = Carbon::createFromTime(0, 0, 0);
                foreach($data as $key => $hour){
                   if($hour){

                       $totalHour = Carbon::parse($totalHour)->diff((Carbon::parse($hour)))->format('%H:%I:%S');
                   }
                }
                $data['workday_id'] = $workday->id;
                $data['day'] = $day;
                if($totalHour){
                    $data['hour'] = Carbon::parse($totalHour);
                }

               $this->workdayProgramsRepository->create($data);
            }

        }catch(Exception $e){
            return $e->getMessage();
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar atualizar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('workday.show',$workday->uuid)->with('message', "Item atualizado com sucesso.");
    }

    public function destroyWorkday($workday)
    {
        try{
            $this->workdayRepository->delete($workday->id);
        }catch(Exception $e){
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar exluir o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('workday.index')->with('message', "Item excluido com sucesso.");
    }
}
