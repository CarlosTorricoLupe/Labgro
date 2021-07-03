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
                'unit_measure' => 'Ltr',
                'kind' => 'Pesetas'
            ],
            [
                'unit_measure' => 'Kgr',
                'kind' => 'gravedad'
            ],
            [
                'unit_measure' => 'Mlt',
                'kind' => 'Volumen'
            ],
            [
                'unit_measure' => 'k',
                'kind' => 'Peso'
            ]
        ];
        foreach($units as $key => $value){
            Unit::create($value);
        }
    }
}
