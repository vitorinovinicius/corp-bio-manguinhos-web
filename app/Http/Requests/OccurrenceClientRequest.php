<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OccurrenceClientRequest extends FormRequest
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
                        'name' => 'required|string',
                        'cpf_cnpj' => 'string|nullable', //|unique:occurrence_clients
                        'email' => 'string|nullable', //|unique:occurrence_clients
                        'client_number' => 'numeric|nullable',
                        'address' => 'required|string',
//                        'number' => 'required|numeric',
//                        'cep' => 'required|string',
                        'district' => 'required|string',
                        'city' => 'required|string',
//                        'uf' => 'required|string',
                        'complement' => 'string|nullable',
                        'reference' => 'string|nullable',
                        'status' => 'string|nullable',
//                    'phone' => 'string|nullable',
                    ];
                }
            case 'POST':
                {
                    return [
                        'name' => 'required|string',
                        'cpf' => 'string|nullable', //|unique:occurrence_clients
                        'email' => 'string|nullable', //|unique:occurrence_clients
                        'client_number' => 'numeric|nullable|unique:occurrence_clients',
                        'address' => 'required|string',
//                        'number' => 'required|numeric',
//                        'cep' => 'required|string',
                        'district' => 'required|string',
                        'city' => 'required|string',
//                        'uf' => 'required|string',
                        'complement' => 'string|nullable',
                        'reference' => 'string|nullable',
                        'status' => 'string|nullable',
//                    'phone' => 'string|nullable',
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
            'name' => 'Nome',
            'cpf' => 'CPF',
            'email' => 'E-mail',
            'client_number' => 'Nº cliente',
            'address' => 'Endereço',
            'number' => 'Nº',
            'cep' => 'CEP',
            'district' => 'Bairro',
            'city' => 'Cidade',
            'uf' => 'Estado',
            'complement' => 'Complemento',
            'reference' => 'Referência',
//            'phone' => 'Telefone',
        ];

    }
}
