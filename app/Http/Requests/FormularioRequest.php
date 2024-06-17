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
                    'ano' => 'required|int|unique:formularios'
                ];
            }
            case 'PUT': {
                $id = $this->route()->parameter("user")->id;
                return [
                    'ano' => 'required|int|unique:formularios'
                ];
            }
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'ano.required' => 'O ano é obrigatório',
        ];
    }
}
