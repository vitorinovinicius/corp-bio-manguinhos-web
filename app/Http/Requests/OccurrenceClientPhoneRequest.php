<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OccurrenceClientPhoneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
                    'phone' => 'string',
                    'obs' => 'string|nullable',
                ];
            }
            case 'POST': {
                return [
                    'phone' => 'string',
                    'obs' => 'string|nullable',
                ];
            }
            default:
                break;
        }

    }

    //Tradução dos campos
    public function attributes()
    {
        return[
            'phone' => 'Telefone',
        ];

    }
}
