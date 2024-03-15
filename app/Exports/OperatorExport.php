<?php

    namespace App\Exports;


    use Maatwebsite\Excel\Concerns\FromArray;
    use Maatwebsite\Excel\Concerns\ShouldAutoSize;
    use Maatwebsite\Excel\Concerns\WithHeadings;
    use Maatwebsite\Excel\Concerns\WithStyles;
    use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


    class OperatorExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
    {

         /**
         * @var null
         */
        private $operators;


        /**
         * OccurrenceExport constructor.
         * @param null $occurrences
         */
        public function __construct($operators = null)
        {
            $this->operators = $operators;
        }

        public function array(): array
        {
            $data = array();

            foreach ($this->operators as $key => $operator) {

                $data[$key]['ID'] = $operator->id;
                $data[$key]['ECC'] = optional($operator->contractor)->name;
                $data[$key]['NOME'] = $operator->name;
                $data[$key]['CPF'] = (!empty($operator->cpf) ? $this->maskCpf($operator->cpf) : "");
                $data[$key]['E-MAIL'] = $operator->email;
                $data[$key]['TIPO'] = $operator->getTypeOperator();
                $data[$key]['STATUS'] = ($operator->status == 1) ? "Habilitado" : "Desabilitado";
                $data[$key]['EQUIPAMENTO (CELULAR)'] = $operator->device . "Version:" . $operator->device_version;
                $data[$key]['CÓDIGO DO CELULAR'] = $operator->mobile_number;
                $data[$key]['MANÔMETRO'] = ($operator->manometro) ? $operator->manometro : "NÃO POSSUI";
                $data[$key]['ANALISADOR DE GÁS'] = ($operator->detector_de_gas) ? $operator->detector_de_gas : "NÃO POSSUI";;
                $data[$key]['CNH'] = ($operator->cnh) ? ($operator->cnh) : "NÃO POSSUI";
                $data[$key]['TIPO CNH'] = ($operator->cnh_type) ? $operator->cnh_type : "NÃO POSSUI";
                $data[$key]['VENCIMENTO CNH'] = ($operator->cnh_expires) ? $operator->cnh_expires() : "NÃO POSSUI";
                $data[$key]['VEÍCULO - PLACA'] = (optional($operator->vehicle)->placa) ? $operator->vehicle->placa : "NÃO POSSUI";
                $data[$key]['VEÍCULO - MARCA'] = (optional($operator->vehicle)->brand) ? $operator->vehicle->brand : "NÃO POSSUI";
                $data[$key]['VEÍCULO - MODELO'] = (optional($operator->vehicle)->model) ? $operator->vehicle->model : "NÃO POSSUI";

            }

            return $data;
        }

        public function headings(): array
        {
            return [
                'ID',
                'ECC',
                'NOME',
                'CPF',
                'E-MAIL',
                'TIPO',
                'STATUS',
                'EQUIPAMENTO (CELULAR)',
                'CÓDIGO DO CELULAR',
                'MANÔMETRO',
                'ANALISADOR DE GÁS',
                'CNH',
                'TIPO CNH',
                'VENCIMENTO CNH',
                'VEÍCULO - PLACA',
                'VEÍCULO - MODELO',
            ];
        }

        public function styles(Worksheet $sheet)
        {
            $count = count($this->array());
            $count = $count+1;

            return [
                // Style the first row as bold text.
                1 => ['font' => ['bold' => true]],
                'A1:AC'.$count => ['borders' => ['allBorders' =>[
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '111111'],
                ]]],
            ];
        }

        private function maskCpf($cpf)
        {
            $mask = '###.###.###-##';
            $cpf = str_replace('-', '', str_replace(".", "", $cpf));
            if (is_numeric($cpf) && strlen($cpf) == 11) {
                for ($i = 0; $i < strlen($cpf); $i++) {
                    $mask[strpos($mask, "#")] = $cpf[$i];
                }
            } else {
                return $cpf;
            }
            return $mask;
        }
    }
