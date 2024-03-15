<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
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
            {
                return [];
            }
            case 'DELETE':
            {
                return [];
            }
            case 'PUT':
            {
                return [

                    'year' => 'required|string|int',
                    'document_date' => 'required|date',
                    'due_date' => 'required|date',
                    'placa' => 'required|string',//
                    'chassi' => 'required|string',
                    'brand' => 'required|string',
                    'model' => 'required|string',
                    'type' => 'required|string',
                ];
            }
            case 'POST':
            {
                return [
                    'year' => 'required|string|int',
                    'document_date' => 'required|date',
                    'due_date' => 'required|date',
                    'placa' => 'required|string',
                    'chassi' => 'required|string',
                    'brand' => 'required|string',
                    'model' => 'required|string',
                    'type' => 'required|string',
                ];
            }
            default:
                break;
        }
    }

    //Tradução dos campos
    public function attributes()
    {
        return [
            'year' => 'Ano do veículo',
            'document_date' => 'Data do documento',
            'due_date' => 'Data do vencimentos',
            'placa' => 'Placa',
            'chassi' => 'Chassi',
            'brand' => 'Marca',
            'model' => 'Modelo',
            'type' => 'Tipo',
        ];

    }
}
