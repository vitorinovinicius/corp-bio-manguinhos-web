<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class InterferenceRequest extends FormRequest
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
                case 'POST':
                    {
                        return [
//                            'description' => 'required:max:255|min:3|string|unique:interferences',
                            'description' => 'required:max:255|min:3|string|unique:interferences,description,NULL,id,contractor_id,'.\Auth::user()->contractor_id,
                        ];
                    }
                case 'PUT':
                    {
                        $id = $this->route()->parameter("interference")->id;
                        return [
//                            'description' => 'required:max:255|min:3|string',
                            'description' => 'required:max:255|min:3|string|unique:interferences,description,'.$id.',id,contractor_id,'.\Auth::user()->contractor_id,

                        ];
                    }
                default:
                    break;
            }
        }

        //Personalizar mensagem
        public function messages()
        {
            return [//'description.required' => 'A Descrição é obrigatório',
            ];
        }

        //Tradução dos campos
        public function attributes()
        {
            return [//            'description' => 'Descrição',
            ];

        }
    }
