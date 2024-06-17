<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormularioRequest extends FormRequest
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
                    'formulario_id' => 'required',
                    'descricao' => 'required',
                    'setor_id' => 'required',
                    'limite_caracteres' => 'required',
                ];
            }
            case 'PUT': {
                return [
                    'formulario_id' => 'required',
                    'descricao' => 'required',
                    'setor_id' => 'required',
                    'limite_caracteres' => 'required',
                ];
            }
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'formulario_id.required' => 'O formulrio é obrigatório',
            'descricao.required' => 'A descrição é obrigatório',
            'setor_id.required' => 'O setor é obrigatório',
            'limite_caracteres.required' => 'O limite de caracteres é obrigatório',
        ];
    }
}
