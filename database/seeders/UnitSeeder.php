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
                'unit_measure' => 'ton',
                'kind' => 'Peso'
            ],
            [
                'unit_measure' => 'Kg',
                'kind' => 'Peso'
            ],
            [
                'unit_measure' => 'Caja',
                'kind' => 'Adquisición'
            ],
            [
                'unit_measure' => 'Unidad',
                'kind' => 'Adquisición'
            ],
            [
                'unit_measure' => 'Hojas',
                'kind' => 'Adquisición'
            ],
            [
                'unit_measure' => 'Ltr',
                'kind' => 'Capacidad'
            ],
            [
                'unit_measure' => 'gal',
                'kind' => 'Capacidad'
            ]
        ];
    
        foreach($units as $key => $value){
            Unit::create($value);
        }
    }
}
