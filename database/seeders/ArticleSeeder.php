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

        $units1 = Unit::where('unit_measure','Ltr')->orWhere('kind','Pesetas')->firts();
        $units2 = Unit::where('unit_measure','Kgr')->orWhere('kind','gravedad')->firts();
        $units3 = Unit::where('unit_measure','Mlt')->orWhere('kind','Volumen')->firts();
        $units4 = Unit::where('unit_measure','k')->orWhere('kind','Peso')->firts();

        $articles= [
            [
                'name_article' => 'Embase de 700 cc',
                'category_id' => $categorie2->id,
                'stock'=> '50',
                'unit_id'=> $units1->id

            ],
            [
                'name_article' => 'Hojas bond tamaño carta',
                'category_id' => $categorie1->id,
                'stock'=> '15',
                'unit_id'=> $units2->id
            ],
            [
                'name_article' => 'Leche',
                'category_id'  => $categorie3->id,
                'stock'=> '100',
                'unit_id'=> $units3->id
            ],
            [
                'name_article' => 'Yogurt',
                'category_id' => $categorie4->id,
                'stock'=> '100',
                'unit_id'=> $units4->id
            ]
        ];
        foreach($articles as $key => $value){
            Article::create($value);
        }

    }
}
