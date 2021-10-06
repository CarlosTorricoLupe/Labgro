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
                'kind' => 'Peso'
            ],
            [
                'unit_measure' => 'Kg',
                'kind' => 'Peso'
            ],
            [
                'unit_measure' => 'Caja',
                'kind' => 'Otro'
            ],
            [
                'unit_measure' => 'Unidad',
                'kind' => 'Otro'
            ],
            [
                'unit_measure' => 'Hojas',
                'kind' => 'Otro'
            ],
            [
                'unit_measure' => 'Ltr',
                'kind' => 'Capacidad'
            ],
            [
                'unit_measure' => 'Gal',
                'kind' => 'Capacidad'
            ],
            [
            'unit_measure' => 'Sobres',
            'kind' => 'Otro'
            ],

        ];

        foreach($units as $key => $value){
            Unit::create($value);
        }
    }
}
