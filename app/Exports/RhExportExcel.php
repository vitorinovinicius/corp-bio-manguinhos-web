<?php


    namespace App\Exports;


    use App\Criteria\MoveCriteria;
    use Maatwebsite\Excel\Concerns\FromArray;
    use Maatwebsite\Excel\Concerns\ShouldAutoSize;
    use Maatwebsite\Excel\Concerns\WithHeadings;
    use Maatwebsite\Excel\Concerns\WithStyles;
    use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
    use Maatwebsite\Excel\Concerns\WithColumnWidths;
    use Maatwebsite\Excel\Concerns\WithEvents;
    class RhExportExcel implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithColumnWidths
    {
        private $moves;


        /**
         * RhExportExcel constructor.
         */
        public function __construct($moves)
        {
            $this->moves = $moves;
        }

        public function array(): array
        {
            $data = array();

            foreach ($this->moves as $key => $move) {
                $data[$key]['ID'] = optional($move->operator)->id;
                $data[$key]['Nome'] = optional($move->operator)->name;
                $data[$key]['E-mail'] = optional($move->operator)->email;
                $data[$key]['ECC'] = optional($move->operator)->contractor->name;
                $data[$key]['Tipo'] = $move->move_type->name;
                $data[$key]['Data/Hora'] = $move->dateCheckin();
            }

            return $data;

        }

        public function headings(): array
        {
            return [
                "ID",
                'Nome',
                'E-maiL',
                'Empresa',
                'Tipo',
                'Data/Hora'
            ];
        }

        public function styles(Worksheet $sheet)
        {
            $count = $this->moves->count();
            $count = $count+1;

            return [
                // Style the first row as bold text.
                1 => ['font' => ['bold' => true]],
                'A1:F'.$count => [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                                        
                    'borders' => ['allBorders' =>[
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '111111'],                   
                ]]],
                
            ];
        }

        public function columnWidths(): array
        {
            return [
                'A' => 5,
                'B' => 22,            
                'C' => 22,            
                'D' => 22,            
                'E' => 22,            
                'F' => 22,            
            ];  
        }

    }
