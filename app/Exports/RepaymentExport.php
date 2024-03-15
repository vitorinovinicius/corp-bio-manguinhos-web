<?php


    namespace App\Exports;


    use Maatwebsite\Excel\Concerns\FromArray;
    use Maatwebsite\Excel\Concerns\ShouldAutoSize;
    use Maatwebsite\Excel\Concerns\WithHeadings;
    use Maatwebsite\Excel\Concerns\WithStyles;
    use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

    class RepaymentExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
    {
        /**
         * @var null
         */
        private $expenses;


        /**
         * RepaymentExport constructor.
         * @param null $expenses
         */
        public function __construct($expenses = null)
        {
            $this->expenses = $expenses;
        }

        public function array(): array
        {
            $data = array();

            foreach ($this->expenses as $key => $expense) {

                $data[$key]['ID'] = $expense->id;
                $data[$key]['Operador'] = optional($expense->user)->name;
                $data[$key]['OS'] = optional($expense->occurrence)->id;
                $data[$key]['Despesa'] = optional($expense->expenseTypes)->name;
                $data[$key]['Valor'] = number_format((float)$expense->value, 2, ',', '.');
                $data[$key]['Data'] = $expense->dateFormat();            
                $data[$key]['Status'] = statusPayment($expense->status);
            }

            return $data;
        }

        public function headings(): array
        {
            return [
                'ID',
                'Operador',
                'OS',
                'Despesa',
                'Valor',
                'Data',
                'Status',
                
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
    }
