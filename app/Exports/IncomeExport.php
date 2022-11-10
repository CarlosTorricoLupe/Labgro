<?php

namespace App\Exports;

use App\Models\Income;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class IncomeExport implements FromView, WithEvents, ShouldAutoSize
{
    protected $Report;

    public function __construct($controller,$monthone,$monthtwo,$year)
    {
        $this->Report = collect($controller);
        $this->monthone= $monthone;
        $this->monthtwo= $monthtwo;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('incomes', [
            'colection'=>$this->Report
        ]);
    }

    public function registerEvents(): array{

        return [
            AfterSheet::class => function(AfterSheet $event) {

                $last_column = Coordinate::stringFromColumnIndex(10);

                $style_text_center = [
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER
                    ]
                ];

                $style_title=[
                    'font'=>[
                        'name'=>'Cambria',
                        'bold'=>true,
                        'size'=>16,
                    ]
                ];
              
                //$name = $this->name ? "(". $this->Report[0]->name_article .")" : "";


                $event->sheet->getStyle('A1:J1')->applyFromArray([
                    'font'=>[
                        'bold'=>true,
                        'color'=> ['argb'=> 'ffffff']
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color'=>['argb' => 'ff8d8c8c'],
                    ],
                ]);

                $style_entry = [
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color'=>['argb' => 'ffd0d0d0'],
                    ],
                ];

                $highestRow = $event->sheet->getHighestRow();
                $highestColumn = $event->sheet->getHighestColumn();

                for ($row = 2; $row <= $highestRow; ++$row) {
                    $rowselect='A'.$row.':'.$highestColumn.''.$row.'';
                    $event->sheet->getStyle(''.$rowselect.'')->applyFromArray($style_entry);
                }


                $columns_number=['E','F','H','J'];
                foreach($columns_number as $col){
                    $event->sheet->getstyle($col)->getNumberFormat()
                        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                }
            },
        ];
    }

   
}
