<?php

namespace App\Exports;

use App\Models\Article;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class PhysicalReportExport implements FromCollection
{

    use Exportable;

    public function __construct(Collection $collection)
    {
        $this->Report = $collection;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->Report;
    }
}
