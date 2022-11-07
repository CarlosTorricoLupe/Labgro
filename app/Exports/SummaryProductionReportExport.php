<?php

namespace App\Exports;

use App\Models\Production;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SummaryProductionReportExport implements FromCollection, WithHeadings,ShouldAutoSize, WithEvents
{

    public function __construct($controller,$monthone,$monthtwo)
    {
        $this->Report = $controller;
        $this->monthone= $monthone;
        $this->monthtwo= $monthtwo;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->Report;
    }

    public function headings(): array{
        $headers1= [
            'Codigo',
            'Producción Estandar Proyectada',
            'Unidad/Presentacion',
            'Costo unit Produccion Bs',
            'Cantidad',
            'Importe',
            'Cantidad',
            'Importe',
            'Cantidad',
            'Importe',
        ];
        return[$headers1];
    }

    public function registerEvents(): array{
        
        return [
            AfterSheet::class => function(AfterSheet $event) {
    
                $last_column = Coordinate::stringFromColumnIndex(count($this->Report[0]));
    
                $last_row = count($this->Report) + 2 + 1 + 1;
    
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

                $style_wrap_center=[
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];
    
                $event->sheet->insertNewRowBefore(1, 4);
    
                $event->sheet->mergeCells(sprintf('A1:%s1',$last_column));
                $event->sheet->mergeCells(sprintf('A2:%s2',$last_column));
                $event->sheet->mergeCells(sprintf('E4:F4'));
                $event->sheet->mergeCells(sprintf('G4:H4'));
                $event->sheet->mergeCells(sprintf('I4:J4'));

                $event->sheet->setCellValue('A1','RESUMEN DE PRODUCCIÓN');
                $event->sheet->setCellValue('A2',$this->monthone.' a '.$this->monthtwo);
                $event->sheet->setCellValue('E4','Total Unidades Producidas');
                $event->sheet->setCellValue('G4','Total Productos Defectuosos/Bajos');
                $event->sheet->setCellValue('I4','Total Efectivamente Producido');


                $columns_gray=['A4:D4','A5:D5'];
                foreach($columns_gray as $col){
                    $event->sheet->getStyle($col)->applyFromArray([
                            'font'=>[
                                'bold'=>true,
                                'color'=> ['argb'=> 'ffffff']
                            ],
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'color'=>['argb' => 'ff8d8c8c'],
                            ],
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                ],
                            ],
                        ]);
                }  
                

                $columns_red=['E4','E5','F5'];
                foreach($columns_red as $col){
                        $event->sheet->getStyle($col)->applyFromArray([
                                'font'=>[
                                    'bold'=>true,
                                    'color'=> ['argb'=> 'ffffff']
                                ],
                                'fill' => [
                                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                    'color'=>['argb' => 'FFFF0000'],
                                ],
                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    ],
                                ],
                            ]);
                }


                $columns_blue=['G4','G5','H5'];
                foreach($columns_blue as $col){
                    $event->sheet->getStyle($col)->applyFromArray([
                            'font'=>[
                                'bold'=>true,
                                'color'=> ['argb'=> 'ffffff']
                            ],
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'color'=>['argb' => 'ff242e6f'],
                            ],
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                ],
                            ],
                        ]);
                }

                $columns_green=['I4','I5','J5'];
                foreach($columns_green as $col){
                    $event->sheet->getStyle($col)->applyFromArray([
                            'font'=>[
                                'bold'=>true,
                                'color'=> ['argb'=> 'ffffff']
                            ],
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'color'=>['argb' => 'ff59b26a'],
                            ],
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                ],
                            ],
                        ]);
                }

                $event->sheet->getStyle('J3')->applyFromArray([
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                $event->sheet->getStyle('K4')->applyFromArray([
                    'borders' => [
                        'left' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                $style_entry = array(
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color'=>['argb' => 'ffd0d0d0'],
                    ],
                    );
        
                    $highestRow = $event->sheet->getHighestRow();
                    $highestColumn = $event->sheet->getHighestColumn(); 
                    for ($row = 3; $row <= $highestRow; ++$row) {
                                $slaHours = $event->sheet->getCellByColumnAndRow(3, $row)->getValue();
                                if( $slaHours == 'Ingreso') {    
                                $rowselect='A'.$row.':'.$highestColumn.''.$row.'';
                                $event->sheet->getStyle(''.$rowselect.'')->applyFromArray($style_entry);
                        }
                    }

                $event->sheet->getStyle('A1:A2')->applyFromArray($style_text_center);
                $event->sheet->getStyle('A1:A2')->applyFromArray($style_title);
                $event->sheet->getStyle('D4:H4')->applyFromArray($style_text_center);
                $event->sheet->getStyle('C5')->applyFromArray($style_text_center);
                $event->sheet->getStyle('B')->applyFromArray($style_text_center);
                $event->sheet->getStyle('4' , $event->sheet->getHighestRow())->getAlignment()->setWrapText(true);
                $event->sheet->getRowDimension('4')->setRowHeight(44);
                $event->sheet->getStyle('4')->applyFromArray($style_wrap_center);
                // $columns_number=['E','G','I','J','K'];
                // foreach($columns_number as $col){
                //    $event->sheet->getstyle($col)->getNumberFormat()
                //     ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                // }
            },
        ];
    }

}
