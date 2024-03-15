<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OccurrenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET': {
                return [];
            }
            case 'DELETE': {
                return [];
            }
            case 'PUT':{
                return [
                    'operator_id' => 'numeric|nullable|exists:users,id'.\Tenant::ruleExists(),
//                    'contractor_id' => 'numeric|exists:contractors,id'.\Tenant::ruleExists(),
                    'occurrence_type_id' => 'numeric|exists:occurrence_types,id'.\Tenant::ruleExists(),
                    'occurrence_client_id' => 'numeric|nullable|exists:occurrence_clients,id'.\Tenant::ruleExists(),
                    'region_id' => 'numeric|nullable|exists:regions,id'.\Tenant::ruleExists(),
                    'cancelamento_status_id' => 'numeric|exists:cancelamento_statuses,id'.\Tenant::ruleExists(),

                     'priority' => 'nullable|numeric',
                    'schedule_date' => 'string|nullable',
                    'schedule_date_submit' => 'string|nullable',
                    'obs_os' => 'string|nullable',

                    'check_in' => 'string|nullable',
                    'check_out' => 'string|nullable',
                    'check_in_lat' => 'string|nullable',
                    'check_in_long' => 'string|nullable',
                    'check_out_lat' => 'string|nullable',
                    'check_out_long' => 'string|nullable',

                    'date_is_received' => 'string|nullable',
                    'date_finish' => 'string|nullable',
                    'motivo_nao_realizacao' => 'string',
                    'order_client' => 'string|nullable',
                    'status' => 'numeric|nullable',
                ];
            }
            case 'POST': {
                return [

                    'operator_id' => 'numeric|nullable|exists:users,id'.\Tenant::ruleExists(),
//                    'contractor_id' => 'numeric|exists:contractor_id,id'.\Tenant::ruleExists(),
                    'occurrence_type_id' => 'numeric|exists:occurrence_types,id'.\Tenant::ruleExists(),
                    'occurrence_client_id' => 'numeric|nullable|exists:occurrence_clients,id'.\Tenant::ruleExists(),
                    'region_id' => 'numeric|nullable|exists:regions,id'.\Tenant::ruleExists(),
                    'cancelamento_status_id' => 'numeric|exists:cancelamento_statuses,id'.\Tenant::ruleExists(),

                    'priority' => 'nullable|numeric',
                    'schedule_date' => 'string|nullable',
                    'schedule_date_submit' => 'string|nullable',
                    'obs_os' => 'string|nullable',

                    'check_in' => 'string|nullable',
                    'check_out' => 'string|nullable',
                    'check_in_lat' => 'string|nullable',
                    'check_in_long' => 'string|nullable',
                    'check_out_lat' => 'string|nullable',
                    'check_out_long' => 'string|nullable',

                    'date_is_received' => 'string|nullable',
                    'date_finish' => 'string|nullable',
                    'motivo_nao_realizacao' => 'string|nullable',
                    'order_client' => 'string|nullable',
                    'status' => 'numeric|nullable',
                ];
            }
            default:
                break;
        }
    }

    //Mensagem personalizada
    public function messages()
    {
        return [
//            'id.unique' => 'A OS já existe',
        ];
    }

    //Tradução dos campos
    public function attributes()
    {
        return[
            'operator_id' => 'Operador',
            'priority' => 'Prioridade',
            'occurrence_type_id' => 'Tipo da Ocorrência',
            'occurrence_client_id' => 'Cliente',
            'motive' => 'Motivo',
        ];

    }
}
