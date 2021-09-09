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
                'name' => 'Bolsa 500 cc.',
                'role_id'=>2
            ],
            [
                'name' => 'Bolsa 700 cc.',
                'role_id'=>2
            ],
            [
                'name' => 'Botella 1L',
                'role_id'=>5
            ],
            [
                'name' => 'Botella 2L',
                'role_id'=>5
            ],
            [
                'name' => 'Bolsa 1kg',
                'role_id'=>4
            ],
            [
                'name' => 'Bolsa 2kg',
                'role_id'=>4
            ]
        ];
        foreach($presentationUnits as $key => $value){
            PresentationUnit::create($value);
        }
    }
}
