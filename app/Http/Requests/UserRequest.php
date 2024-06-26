<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                    //                    'password' => 'max:15|min:6|string',
                    //                    'repassword' => 'max:15|min:6|string',
                ];
            }
            case 'PUT': {
                return [
                    'name' => 'max:255|min:3|string',
                    //                    'password' => 'max:15|min:6|string',
//                    'repassword' => 'max:15|min:6|string',
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
        ];
    }

    //Tradução dos campos
    public function attributes()
    {
        return[
            'name' => 'Nome',
            'email' => 'E-mail',
            'password' => 'Senha',
            'repassword' => 'Repetir senha',
        ];
    }
}
