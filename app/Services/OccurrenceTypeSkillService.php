<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06/07/2020
 * Time: 18:13
 */

namespace App\Services;


use App\Criteria\OccurrenceTypeSkillCriteria;
use App\Criteria\OccurrenceTypeSkillRemoveCriteria;
use App\Repositories\SkillRepository;

class OccurrenceTypeSkillService
{
    /**
     * @var SkillRepository
     */
    private $skillRepository;


    /**
     * OccurrenceTypeSkillService constructor.
     */
    public function __construct(SkillRepository $skillRepository)
    {
        $this->skillRepository = $skillRepository;
    }

    /**
     * @param $occurrence
     */
    public function associate_skill($occurrence_type)
    {
        $this->skillRepository->pushCriteria(new OccurrenceTypeSkillCriteria($occurrence_type->id));
        $skills = $this->skillRepository->paginate(50);

        return view('occurrence_types.associate_skills', compact('skills','occurrence_type'));
    }

    public function sync_skill_store($occurrence_type, $request, $flag = null)
    {
        $data = $request->all();
        $skills_id = $data["ids"];
        $skills = explode(",", $skills_id);

        $erro = array();

        try{

        foreach ($skills as $key => $value) {

            $skill = $this->skillRepository->findWhere(["id" => $value])->first();
            if ($skill) {
                if ($flag == 1 || $flag == null) {
                    //Associa a equipe
                    $occurrence_type->skills()->attach($skill);
                    $mensagem_ok = "Itens associados com sucesso";
                } elseif ($flag == 2) {
                    //Desassocia a equipe
                    $occurrence_type->skills()->detach($skill);
                    $mensagem_ok = "Itens removidos com sucesso";
                }
            } else {
                //Não há agendamento para essa ocorrência
                $erro[] = $value;
            }
        }
        if (count($erro) > 0) {
            return response()->json([
                'retorno' => 2,
                'mensagem' => 'Houve item que não pode ser associado, segue IDs (' . implode(", ", $erro) . ')'
            ]);
        } else {
            return response()->json([
                'retorno' => 1,
                'mensagem' => $mensagem_ok
            ]);
        }
        } catch (\Exception $exception){
            return response()->json([
                'retorno' => 2,
                'mensagem' => 'Houve um erro no processamento: '. $exception->getMessage()
            ]);
        }
    }

    public function disassociate_skill($occurrence_type)
    {
        $this->skillRepository->pushCriteria(new OccurrenceTypeSkillRemoveCriteria($occurrence_type->id));
        $skills = $this->skillRepository->paginate(50);

        return view('occurrence_types.desassociate_skills', compact('skills','occurrence_type'));
    }
}