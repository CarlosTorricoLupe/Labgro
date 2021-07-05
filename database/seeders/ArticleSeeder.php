<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\Unit;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorie1 = Category::where('name','Material de escritorio')->first();
        $categorie2 = Category::where('name','Material de limpieza')->first();
        $categorie3 = Category::where('name','Materia Prima')->first();
        $categorie4 = Category::where('name','Insumos')->first();

        $units1 = Unit::where('kind','Peso')->where('unit_measure','Ton')->first();
        $units2 = Unit::where('kind','Peso')->where('unit_measure','Kg')->first();
        $units3 = Unit::where('kind','Adquisicion')->where('unit_measure','Caja')->first();
        $units4 = Unit::where('kind','Adquisicion')->where('unit_measure','Unidad')->first();
        $units5 = Unit::where('kind','Adquisicion')->where('unit_measure','Hojas')->first();
        $units6 = Unit::where('kind','Capacidad')->where('unit_measure','Ltr')->first();
        $units7 = Unit::where('kind','Capacidad')->where('unit_measure','Gal')->first();

        $articles= [
            [
                'name_article' => 'Azucar',
                'category_id' => $categorie4->id,
                'stock'=> '50',
                'unit_id'=> 1
            ],
            [
                'name_article' => 'Arroz',
                'category_id' => $categorie4->id,
                'stock'=> '15',
                'unit_id'=> 2
            ],
            [
                'name_article' => 'Grampas',
                'category_id'  => $categorie1->id,
                'stock'=> '100',
                'unit_id'=> 3
            ],
            [
                'name_article' => 'Tijeras',
                'category_id' => $categorie1->id,
                'stock'=> '100',
                'unit_id'=> 4
            ],
            [
                'name_article' => 'Papal Bon',
                'category_id'  => $categorie1->id,
                'stock'=> '100',
                'unit_id'=> 5
            ],
            [
                'name_article' => 'Aceite',
                'category_id'  => $categorie3->id,
                'stock'=> '100',
                'unit_id'=> 6
            ],
            [
                'name_article' => 'Leche',
                'category_id'  => $categorie3->id,
                'stock'=> '100',
                'unit_id'=> 7
            ],
        ];
        foreach($articles as $key => $value){
            Article::create($value);
        }

    }
}
