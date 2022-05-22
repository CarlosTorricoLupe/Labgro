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
                'name' => 'Producción Frutas'
            ],
            [
                'name' => 'Producción Cárnicos'
            ],
            [
                'name' => 'Producción Lácteos'
            ],

        ];
        foreach($sections as $key => $value){
            Section::create($value);
        }
    }
}
