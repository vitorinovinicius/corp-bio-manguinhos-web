<?php


    namespace App\Exports;


    use Maatwebsite\Excel\Concerns\FromArray;
    use Maatwebsite\Excel\Concerns\ShouldAutoSize;
    use Maatwebsite\Excel\Concerns\WithHeadings;
    use Maatwebsite\Excel\Concerns\WithStyles;
    use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

    class OccurrenceExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
    {
        /**
         * @var null
         */
        private $occurrences;


        /**
         * OccurrenceExport constructor.
         * @param null $occurrences
         */
        public function __construct($occurrences = null)
        {
            $this->occurrences = $occurrences;
        }

        public function array(): array
        {
            $data = array();

            foreach ($this->occurrences as $key => $occurrence) {

                $data[$key]['ID'] = $occurrence->id;
                $data[$key]['Status'] = $occurrence->getStatus();
                $data[$key]['Data agendamento'] = (!empty($occurrence->schedule_date) ? date('d/m/Y', strtotime($occurrence->schedule_date)) : '');
                $data[$key]['Data de criação'] = (!empty($occurrence->created_at) ? date('d/m/Y', strtotime($occurrence->created_at)) : '');
                $data[$key]['Período'] = $occurrence->shift();
                $data[$key]['Status SMS'] = $occurrence->status_sms();
                $data[$key]['Empreiteira'] = (!empty($occurrence->contractor_id) ? optional($occurrence->contractor)->name : '');
                $data[$key]['Número OS'] = $occurrence->numero_os;
                $data[$key]['Nome OS'] = optional($occurrence->occurrence_type)->name;
                $data[$key]['Número Cliente'] = $occurrence->numero_cliente;
                $data[$key]['Nome Cliente'] = optional($occurrence->occurrence_client)->name;
                $data[$key]['CPF / CNPJ do Cliente'] = optional($occurrence->occurrence_client)->cpf_cnpj;
                $data[$key]['email'] = optional($occurrence->occurrence_client)->email;
                $data[$key]['Endereço Cliente'] = optional($occurrence->occurrence_client)->address . " " . optional($occurrence->occurrence_client)->number . " - " . optional($occurrence->occurrence_client)->district . ", " . optional($occurrence->occurrence_client)->city;
                $data[$key]['Telefone 1'] = (isset($occurrence->occurrence_client->occurrence_client_phones[0]->phone)) ? $occurrence->occurrence_client->occurrence_client_phones[0]->phone : '';
                $data[$key]['Telefone 2'] = (isset($occurrence->occurrence_client->occurrence_client_phones[1]->phone)) ? $occurrence->occurrence_client->occurrence_client_phones[1]->phone : '';
                $data[$key]['Telefone 3'] = (isset($occurrence->occurrence_client->occurrence_client_phones[2]->phone)) ? $occurrence->occurrence_client->occurrence_client_phones[2]->phone : '';
                $data[$key]['Bairro'] = optional($occurrence->occurrence_client)->district;
                $data[$key]['Município'] = optional($occurrence->occurrence_client)->district;
                $data[$key]['Cidade'] = optional($occurrence->occurrence_client)->city;
                $data[$key]['CEP'] = optional($occurrence->occurrence_client)->cep;
                $data[$key]['Executor Serviço'] = optional($occurrence->operator)->name;

                $data[$key]['prioridade'] = priority_name($occurrence->priority);
                $data[$key]['Check-in'] = (!empty($occurrence->check_in) ? date('d/m/Y H:i:s', strtotime($occurrence->check_in)) : '');
                $data[$key]['Check-out'] = (!empty($occurrence->check_out) ? date('d/m/Y H:i:s', strtotime($occurrence->check_out)) : '');
                $data[$key]['Data de execução'] = (!empty($occurrence->check_out) ? date('d/m/Y H:i:s', strtotime($occurrence->check_out)) : '');
                $data[$key]['Tempo de execução'] = (!empty($occurrence->check_in && !empty($occurrence->check_out)) ? calcula_minutos($occurrence->check_in, $occurrence->check_out) : '');
                $data[$key]['Obs. Empreiteira'] = optional($occurrence->occurrence_data_basic)->obs_empreiteira;
                $data[$key]['Motivo Não Realizado'] = optional($occurrence->cancelamento_status)->name;
                $data[$key]['Descrição não realizado'] = $occurrence->motivo_nao_realizacao;
                $data[$key]['Observações do atendimento'] = $occurrence->obs_os;

                $data[$key]['Interferências'] = $occurrence->interferences->implode("description", "|");


                if (request()->input("export_dynamics") == 1) {
                    $forms = $occurrence->occurrence_dynamo_last();
                    if ($forms && isset($forms->json["forms"])) {
                        foreach ($forms->json["forms"] as $form) {
                            if (isset($form["sections"]) && !empty($form["sections"]) && is_array($form["sections"])) {
                                foreach ($form["sections"] as $section) {
                                    if (isset($section["form_fields"]) && !empty($section["form_fields"])) {
                                        foreach ($section["form_fields"] as $field) {
                                            $data[$key][$section["name"] . ' - ' . $field["name"]] = (isset($field["value"]) && !empty($field["value"]) && isset($field['type_field']) && $field['type_field'] != 5 && $field['type_field'] != 7) ? $field["value"] : "";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

            }

            return $data;
        }

        public function headings(): array
        {
            $arrays = $this->array();
            $headings = [];
            foreach ($arrays as $array) {
                foreach ($array as $key => $value) {
                    if (!in_array($key, $headings)) {
                        $headings[] = $key;
                    }
                }
            }

            return $headings;
        }

        public function styles(Worksheet $sheet)
        {
            $count = count($this->array());
            $count = $count+1;

            return [
                // Style the first row as bold text.
                1 => ['font' => ['bold' => true]],
                'A1:AF'.$count => ['borders' => ['allBorders' =>[
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '111111'],
                ]]],
            ];
        }
    }
