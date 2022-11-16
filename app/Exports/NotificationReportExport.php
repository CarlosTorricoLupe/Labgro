<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class NotificationReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    use Exportable;

    protected $Report;
    protected $name;
    protected $monthone;
    protected $monthtwo;
    protected $year;
    private $status;

    public function __construct($art, $name, $monthone, $monthtwo, $year, $status)
    {
        $this->Report = $art;
        $this->name= $name;
        $this->monthone= $monthone;
        $this->monthtwo= $monthtwo;
        $this->year= $year;
        $this->status=$status;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $result = [];
        $cont = 0;
        foreach ($this->Report as $notification){
            foreach ($notification['materials'] as $material){
                $result[$cont]['section_name'] = $notification['section_name'];
                $result[$cont]['receipt'] = $notification['receipt'];
                $result[$cont]['order_date'] = $notification['order_date'];
                $result[$cont]['name_article'] = $material['name_article'];
                $result[$cont]['quantity_materials'] = $notification['quantity_materials'];
                $cont++;
            }
        }
        return collect($result);
    }

    public function headings(): array{

        $headers1= [
            'Area',
            'Comprobante',
            'Fecha Solicitud',
            'Insumo',
            'Cantidad Solicitada.',
        ];
        return[$headers1];
    }

    public function registerEvents(): array{

        return [
            AfterSheet::class => function(AfterSheet $event) {

                $last_column = Coordinate::stringFromColumnIndex(5);

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

                $event->sheet->insertNewRowBefore(1, 3);

                $event->sheet->mergeCells(sprintf('A1:%s1',$last_column ));
                $event->sheet->mergeCells(sprintf('A2:%s2',$last_column ));

                $date1 = Carbon::parse('01-'.$this->monthone.'-22')->locale('es');
                $date2 = Carbon::parse('01-'.$this->monthtwo.'-22')->locale('es');

                $name = $this->status ? "(". $this->status .")" : "";
                $event->sheet->setCellValue('A1','NOTIFICACIONES '. $name);
                $event->sheet->setCellValue('A2',$date1->monthName.' a '.$date2->monthName. ' de '. $this->year);


                $event->sheet->getStyle('A4:E4')->applyFromArray([
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

                for ($row = 5; $row <= $highestRow; ++$row) {
                    $rowselect='A'.$row.':'.$highestColumn.''.$row.'';
                    $event->sheet->getStyle(''.$rowselect.'')->applyFromArray($style_entry);
                }

                $event->sheet->getStyle('A1:A2')->applyFromArray($style_text_center);
                $event->sheet->getStyle('A1:A2')->applyFromArray($style_title);
                $event->sheet->getStyle('D4:H4')->applyFromArray($style_text_center);

            },
        ];
    }

}
