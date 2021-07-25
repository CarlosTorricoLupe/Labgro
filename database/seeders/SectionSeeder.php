<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sections= [
            [
                'name' => 'Laboratorio de suelos y areas'
            ],
            [
                'name' => 'Biblioteca'
            ],
            [
                'name' => 'Biotecnologia'
            ],
            [
                'name' => 'Tecnologia'
            ]
        ];
        foreach($sections as $key => $value){
            Section::create($value);
        }
    }
}