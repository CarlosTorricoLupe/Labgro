<?php

namespace App\Exports;

use App\Models\Production;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DetailProductionReportExport implements FromArray,ShouldAutoSize, WithHeadings, WithMapping, WithEvents
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
    // public function collection()
    // {

    //    $a= json_decode($this->Report);
    //    return $a;
    // }

    public function array():array
    {
        $newArr = [];
        $arr = [];
        foreach($this->Report as $key => $value) {
            $count = [count($value['presentation'])];
            $arrMax = max($count);
                for($i=0; $i < $arrMax; $i++){
                    $arrIndex = $i;
                    $arr['#'] = '';
                    if($arrIndex == '0'){
                        $arr['#'] = $key + 1;
                    }
                    $arr['Fecha_produccion'] =  $value['presentation'][$arrIndex]['Fecha_produccion'];
                    $arr['Cantidad_usada'] =  $value['presentation'][$arrIndex]['Cantidad_usada'];
                    $arr['Codigo'] =  $value['presentation'][$arrIndex]['Codigo'];
                    $arr['Produccion_estandar'] =  $value['presentation'][$arrIndex]['Produccion_estandar'];
                    $arr['Unidad_presentacion'] =  $value['presentation'][$arrIndex]['Unidad_presentacion'];
                    $arr['Costo_unitario'] =  $value['presentation'][$arrIndex]['Costo_unitario'];
                    $arr['Cantidad'] =  $value['presentation'][$arrIndex]['Cantidad'];
                    $arr['Importe'] =  $value['presentation'][$arrIndex]['Importe'];
                    $arr['Cantidad_unidades_defectuosos'] = '0';
                    $arr['Importe_unidades_defectuosos'] = '0';
                    $arr['Cantidad_efectivamente_producido'] =  $value['presentation'][$arrIndex]['Cantidad_efectivamente_producido'];
                    $arr['Importe_efectivamente_producido'] =  $value['presentation'][$arrIndex]['Importe_efectivamente_producido'];
                    $newArr[] = $arr;
                }
        }
       return $newArr;
    }

    public function headings(): array{
        $headers1= [
            'No.',
            'Fecha_produccion',
            'Codigo',
            'Producción Estandar Proyectada',
            'Unidad/presentación',
            'Costo unit de Producción Bs.',
            'Cantidad',
            'Importe Bs',
            'Cantidad',
            'Importe Bs',
            'Cantidad',
            'Importe Bs',
        ];
        return[$headers1];
    }

    public function map($newArr): array{
        
        return[
            $newArr['#'],
            $newArr['Fecha_produccion'],
            $newArr['Codigo'],
            $newArr['Produccion_estandar'],
            $newArr['Unidad_presentacion'],
            $newArr['Costo_unitario'],
            $newArr['Cantidad'],
            $newArr['Importe'],
            $newArr['Cantidad_unidades_defectuosos'],
            $newArr['Importe_unidades_defectuosos'],
            $newArr['Cantidad_efectivamente_producido'],
            $newArr['Importe_efectivamente_producido']
        ];
    }

    public function registerEvents(): array{
        
        return [
            AfterSheet::class => function(AfterSheet $event) {
    
                $last_column = Coordinate::stringFromColumnIndex(count($this->Report));
    
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
                        'wrapText' =>true
                    ],
                ];
    
                $event->sheet->insertNewRowBefore(1, 4);
    
                $event->sheet->mergeCells(sprintf('A1:L1'));
                $event->sheet->mergeCells(sprintf('A2:L2'));
                $event->sheet->mergeCells(sprintf('G4:H4'));
                $event->sheet->mergeCells(sprintf('I4:J4'));
                $event->sheet->mergeCells(sprintf('K4:L4'));

                $event->sheet->setCellValue('A1','KARDEX DETALLE DE PRODUCCIÓN');
                $event->sheet->setCellValue('A2',$this->monthone.' a '.$this->monthtwo);
                $event->sheet->setCellValue('G4','Total Producción');
                $event->sheet->setCellValue('I4','Total Productos Defectuosos/Bajos');
                $event->sheet->setCellValue('K4','Total Efectivamente Producido');


                $columns_gray=['A4:F4','A5:F5'];
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
                

                $columns_red=['G4','G5','H5'];
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


                $columns_blue=['I4','I5','J5'];
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

                $columns_green=['K4','K5','L5'];
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

                $event->sheet->getStyle('L3')->applyFromArray([
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                $event->sheet->getStyle('M4')->applyFromArray([
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
                $event->sheet->getStyle('D5:H5')->applyFromArray($style_text_center);
                $event->sheet->getStyle('C5')->applyFromArray($style_text_center);
                $event->sheet->getStyle('B')->applyFromArray($style_text_center);
                $event->sheet->getStyle('4' , $event->sheet->getHighestRow())->getAlignment()->setWrapText(true);
                $event->sheet->getRowDimension('4')->setRowHeight(44);
                $event->sheet->getStyle('4')->applyFromArray($style_wrap_center);
                $event->sheet->getRowDimension('5')->setRowHeight(35);
                $event->sheet->getStyle('5')->applyFromArray($style_wrap_center);
                $event->sheet->getStyle('D')->applyFromArray($style_wrap_center);
                $event->sheet->getColumnDimension('D')->setAutoSize(false)->setWidth(25);
                $event->sheet->getStyle('D')->applyFromArray($style_wrap_center);
                $event->sheet->getColumnDimension('F')->setAutoSize(false)->setWidth(18);
                $event->sheet->getStyle('F')->applyFromArray($style_wrap_center);
                // $columns_number=['E','G','I','J','K'];
                // foreach($columns_number as $col){
                //    $event->sheet->getstyle($col)->getNumberFormat()
                //     ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                // }
            },
        ];
    }


    
}
