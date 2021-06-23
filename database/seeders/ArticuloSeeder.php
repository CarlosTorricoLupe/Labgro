<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use App\Models\Category;

class ArticuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles= [
            [
                'nombre_articulo' => 'Embase de 700 cc',
                'category_id' => Category::where('name','Material de escritorio')->first(),
                'unidad_medida'=> 'javas',
                'cantidad'=> '5'
            ],
            [
                'nombre_articulo' => 'Hojas bond tamaño carta',
                'category_id' => Category::where('name','Material de limpieza')->first(),
                'unidad_medida'=> 'Paquetes',
                'cantidad'=> '15'
            ],
            [
                'nombre_articulo' => 'Leche',
                'category_id'  => Category::where('name','Materia Prima')->first(),
                'unidad_medida'=> 'Litros',
                'cantidad'=> '100'
            ],
            [
                'nombre_articulo' => 'Yogurt',
                'category_id' => Category::where('name','Insumos')->first(),
                'unidad_medida'=> 'Litros',
                'cantidad'=> '100'
            ]
        ];
        foreach($articles as $key => $value){
            Article::create($value);
        }
    }
}
