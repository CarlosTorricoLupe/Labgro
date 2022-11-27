<?php

namespace App\Exports;

use App\Models\Article;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PhysicalReportExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithEvents
{

    use Exportable;

    public function __construct(Collection $collection,$name,$monthone,$monthtwo,$year)
    {
        $this->Report = $collection;
        $this->name= $name;
        $this->monthone= $monthone;
        $this->monthtwo= $monthtwo;
        $this->year= $year;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->Report;
    }

    public function map($collection): array{
        
        return[
            $collection['fecha'],
            $collection['comprobante'],
            $collection['Origen'],
            $collection['cantidadEntrada'],
            $collection['importeEntrada'],
            $collection['cantidadSalida'],
            $collection['importeSalida'],
            $collection['cantidadSaldo'],
            $collection['importeSaldo'],
            $collection['valorUnit'],
            $collection['precioMedio'],
        ];
    }

    public function headings(): array{
        
        $headers1= [
            'Fecha',
            'Comprobante',
            'Origen',
            'Cantidad',
            'Importe',
            'Cantidad',
            'Importe',
            'Cantidad',
            'Importe',
            'Valor Unitario',
           ' Precio Medio'
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
    
                $event->sheet->insertNewRowBefore(1, 4);
    
                $event->sheet->mergeCells(sprintf('A1:%s1',$last_column));
                $event->sheet->mergeCells(sprintf('A2:%s2',$last_column));
                $event->sheet->mergeCells(sprintf('D4:E4'));
                $event->sheet->mergeCells(sprintf('F4:G4'));
                $event->sheet->mergeCells(sprintf('H4:I4'));
    
                $date1 = Carbon::parse('01-'.$this->monthone.'-22')->locale('es');
                $date2 = Carbon::parse('01-'.$this->monthtwo.'-22')->locale('es');

                if($this->year>2022){
                    $event->sheet->setCellValue('A1','KARDEX FISICO VALORADO APERTURA DE GESTION('.$this->name.')');    
                }else{
                    $event->sheet->setCellValue('A1','KARDEX FISICO VALORADO ('.$this->name.')');
                    $event->sheet->setCellValue('A2',$date1->monthName.' a '.$date2->monthName. ' de '. $this->year);
                }
                $event->sheet->setCellValue('D4','ENTRADAS');
                $event->sheet->setCellValue('F4','SALIDAS');
                $event->sheet->setCellValue('H4','SALDOS');


                $columns_gray=['A4:C4','A5:C5'];
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
                        ]);
                }  
                

                $columns_red=['D4','D5','E5'];
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
                            ]);
                }


                $columns_blue=['F4','F5','G5'];
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
                        ]);
                }

                $columns_green=['H4','H5','I5'];
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
                        ]);
                }
    
                $colums_orange=['J4:K4','J5:K5'];
                foreach($colums_orange as $col){
                    $event->sheet->getStyle($col)->applyFromArray([
                            'font'=>[
                                'bold'=>true,
                                'color'=> ['argb'=> 'ffffff']
                            ],
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'color'=>['argb' => 'ffe4912d'],
                            ],
                        ]);
                }

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
                $columns_number=['E','G','I','J','K'];
                foreach($columns_number as $col){
                   $event->sheet->getstyle($col)->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                }
            },
        ];
    }
}
