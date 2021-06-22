<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories= [
            [
                'name' => 'Material de escritorio'
            ],
            [
                'name' => 'Material de limpieza'
            ],
            [
                'name' => 'Materia Prima'
            ],
            [
                'name' => 'Insumos'
            ]
        ];
        foreach($categories as $key => $value){
            Category::create($value);
        }
    }
}
