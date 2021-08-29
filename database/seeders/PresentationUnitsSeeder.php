<?php

namespace Database\Seeders;

use App\Models\PresentationUnit;
use Illuminate\Database\Seeder;

class PresentationUnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $presentationUnits= [
            [
                'name' => 'Bolsa 500 cc.'
            ],
            [
                'name' => 'Bolsa 700 cc.'
            ],
            [
                'name' => 'Botella 1L'
            ],
            [
                'name' => 'Botella 2L'
            ]
        ];
        foreach($presentationUnits as $key => $value){
            PresentationUnit::create($value);
        }
    }
}
