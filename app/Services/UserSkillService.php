<?php
/**
 * Created by PhpStorm.
 * User: operator
 * Date: 06/07/2020
 * Time: 18:12
 */

namespace App\Services;


use App\Criteria\UserSkillCriteria;
use App\Criteria\UserSkillRemoveCriteria;
use App\Repositories\SkillRepository;

class UserSkillService
{
    /**
     * @var SkillRepository
     */
    private $skillRepository;

    /**
     * UserSkillService constructor.
     * @param SkillRepository $skillRepository
     */
    public function __construct(SkillRepository $skillRepository)
    {
        $this->skillRepository = $skillRepository;
    }

    public function associate_skill($operator)
    {
        $this->skillRepository->pushCriteria(new UserSkillCriteria($operator->id));
        $skills = $this->skillRepository->paginate(50);

        return view('operators.skills.associate_skills', compact('skills','operator'));
    }

    public function sync_skill_store($operator, $request, $flag = null)
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
                        $operator->skills()->attach($skill);
                        $mensagem_ok = "Itens associados com sucesso";
                    } elseif ($flag == 2) {
                        //Desassocia a equipe
                        $operator->skills()->detach($skill);
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

    public function disassociate_skill($operator)
    {
        $this->skillRepository->pushCriteria(new UserSkillRemoveCriteria($operator->id));
        $skills = $this->skillRepository->paginate(50);

        return view('operators.skills.desassociate_skills', compact('skills','operator'));
    }
}