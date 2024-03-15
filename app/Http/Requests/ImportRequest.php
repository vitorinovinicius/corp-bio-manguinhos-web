<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
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
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
//                    'csv' => 'required|mimes:xlsx,txt,xls,csv',
                ];
            }
            case 'PUT': {
                return [

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
            'csv' => 'Importação',
        ];
    }
}
