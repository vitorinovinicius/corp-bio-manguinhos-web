<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinancialCommunicationRequest extends FormRequest
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
            case 'POST': {
                return [
//                    'name'=>'string|required|unique:garages',
//                    'occurrence_id'=>'numeric|nullable|exists:occurrences,id',
//                    'string'=>'string|nullable',
//                    'string'=>'string|required',
//                    'numeric'=>'numeric|required',
//                    'numeric'=>'numeric|nullable',
//                    'boolean'=>'boolean|nullable',
                ];
            }
            case 'PUT': {
                //Para ignorar no unique table, utilize esse código abaixo
//                $id = $this->route()->parameter("garage")->id;
                return [
//                    'name'=>'string|required|unique:garages,name,'.$id,
//                    'occurrence_id'=>'numeric|nullable|exists:occurrences,id',
//                    'string'=>'string|nullable',
//                    'string'=>'string|required',
//                    'numeric'=>'numeric|required',
//                    'numeric'=>'numeric|nullable',
//                    'boolean'=>'boolean|nullable',
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
        return [
//            'open_close' => 'traducao',
        ];

    }

//    public function response(array $errors)
//    {
//        return Response::json($errors);
//    }
}
