<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OperatorRequest extends FormRequest
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
                    'name' => 'required:max:255|min:3|string',
                    'email' => 'required|email|unique:users',
                    'region_id' => 'required|array|min:1'.\Tenant::ruleExists(),
                ];
            }
            case 'PUT': {
                $id = $this->route()->parameter("user")->id;
                return [
                    'name' => 'max:255|min:3|string',
                    'email' => 'email|required|unique:users,email,'.$id,
                    'password' => 'max:15|min:6|string',
                    'repassword' => 'max:15|min:6|string',
                ];
            }
            default:
                break;
        }
    }

    //Personalizar mensagem
    public function messages()
    {
        return [
            //'name.required' => 'O Nome é obrigatório',
            'region_id.required' => 'O campo Região é obrigatório',
        ];
    }

    //Tradução dos campos
    public function attributes()
    {
        return[
            'password' => 'Senha',
            'repassword' => 'Repetir senha',
        ];
    }
}
