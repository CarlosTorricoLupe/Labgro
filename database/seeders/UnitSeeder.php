<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units= [
            [
                'unit_measure' => 'Ton',

            ],
            [
                'unit_measure' => 'Kg',

            ],
            [
                'unit_measure' => 'Caja',

            ],
            [
                'unit_measure' => 'Unidad',

            ],
            [
                'unit_measure' => 'Hojas',

            ],
            [
                'unit_measure' => 'Ltr',

            ],
            [
                'unit_measure' => 'Gal',

            ],
            [
            'unit_measure' => 'Sobres',
            ],

        ];

        foreach($units as $key => $value){
            Unit::create($value);
        }
    }
}
