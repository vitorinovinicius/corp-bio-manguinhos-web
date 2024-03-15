<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppVersionRequest extends FormRequest
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
//                    'version_name'=>'string|required|unique:app_versions',
//                    'version_code'=>'string|required|unique:app_versions',
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
                $id = $this->route()->parameter("app_version")->id;
                return [
//                    'version_name'=>'string|required|unique:app_versions,version_name,'.$id,
//                    'version_code'=>'string|required|unique:app_versions,version_code,'.$id,
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
