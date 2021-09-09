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
                'role_id'=>2,
                'quantity'=>30,
                'stock_min'=>10
            ],
            [
                'name' => 'Bolsa 700 cc.',
                'role_id'=>2,
                'quantity'=>40,
                'stock_min'=>10
            ],
            [
                'name' => 'Botella 1L',
                'role_id'=>5,
                'quantity'=>30,
                'stock_min'=>10
            ],
            [
                'name' => 'Botella 2L',
                'role_id'=>5,
                'quantity'=>50,
                'stock_min'=>10
            ],
            [
                'name' => 'Bolsa 1kg',
                'role_id'=>4,
                'quantity'=>20,
                'stock_min'=>10
            ],
            [
                'name' => 'Bolsa 2kg',
                'role_id'=>4,
                'quantity'=>70,
                'stock_min'=>10
            ]
        ];
        foreach($presentationUnits as $key => $value){
            PresentationUnit::create($value);
        }
    }
}
