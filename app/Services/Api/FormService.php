<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21/02/2019
 * Time: 17:16
 */

namespace App\Services\Api;


use App\Criteria\Api\FormContractorCriteria;
use App\Criteria\Api\FormCriteria;
use App\Criteria\Api\FormDeletedCriteria;
use App\Repositories\FormRepository;
use Illuminate\Http\Request;

class FormService
{
    /**
     * @var FormRepository
     */
    private $formRepository;


    /**
     * OccurrenceTypeService constructor.
     * @param FormRepository $formRepository
     */
    public function __construct(
        FormRepository $formRepository
    )
    {
        $this->formRepository = $formRepository;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getForms(Request $request)
    {
        $all = $request->all();
        $data = $all["forms"];

        $resultTypeServices = ["forms" => []];

        if (count($data) > 0) {
            foreach ($data as $datum) {
                $form = $this->formRepository
                    ->with(['form_sections','form_sections.form_fields'])
                    ->findWhere([
                        "uuid" => $datum['uuid'],
//                        "type_in" => 2,
                        ["version", "<>", $datum['version']],
                    ])
                    ->first();

                if ($form) {
                    $resultTypeServices["forms"][] = $form;
                }

                $uuids[] = $datum["uuid"];
            }

//            dd($uuids);

            //Armazena todos os outros que ainda não tem no celular
            $this->formRepository->pushCriteria(new FormCriteria($uuids));
            $forms = $this->formRepository->all();

        } else {
            $this->formRepository->pushCriteria(new FormContractorCriteria());
            //Pega todas os forms
            $forms = $this->formRepository->with(['form_sections','form_sections.form_fields'])->all();

        }

        if ($forms) {
            foreach ($forms as $form) {
                $resultTypeServices["forms"][] = json_decode($form);
            }
        }


        if ($resultTypeServices) {
            return $resultTypeServices;
        } else {
            return [];
        }
    }

    public function getVersions(Request $request)
    {
        try {

            $all = $request->all();
            $user = \Auth::user();

            $data = $all["forms"];

            $resultTypeServices = ["forms"=>[],"forms_deleteds"=>[]];

            if (count($data) > 0) {
                foreach ($data as $datum) {
                    $form = $this->formRepository->
                    findWhere([
                        "uuid" => $datum['uuid'],
                        "contractor_id" => $user->contractor_id,
                        ["version","<>",$datum['version']],
                    ])->first();

                    if ($form) {
                        $resultTypeServices["forms"][] = json_decode($form->form_versions->last()->json);
                    }

                    $uuids[] = $datum["uuid"];
                }

                //Armazena todos os outros que ainda não tem no celular
                $forms = $this->formRepository->findWhereNotIn("uuid",$uuids)
                    ->where("contractor_id",$user->contractor_id)->all();

                //Pega os formulários que foram deletadas
                $this->formRepository->pushCriteria(new FormDeletedCriteria($uuids));
                $forms_deleteds = $this->formRepository->all();


            } else {
                //Pega todas os forms
                $this->formRepository->pushCriteria(new FormContractorCriteria($user));
                $forms = $this->formRepository
                    ->findWhere(["contractor_id" => $user->contractor_id]);

                $forms_deleteds = [];
            }

            if ($forms) {
                foreach ($forms as $form) {
                    $resultTypeServices["forms"][] = json_decode(optional($form->form_versions->last())->json);
                }
            }
            if ($forms_deleteds) {
                foreach ($forms_deleteds as $forms_deleted) {
                    $resultTypeServices["forms_deleteds"][] = $forms_deleted->uuid;
                }
            }

            if (count($resultTypeServices)) {
                return $resultTypeServices;
            } else {
                return [];
            }


        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro no sistema',"exception"=>$e->getMessage()], 500);
        }
    }
}
