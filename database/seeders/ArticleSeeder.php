<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;

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
        
        $articles= [
            [
                'name_article' => 'Embase de 700 cc',
                'category_id' => $categorie2->id,
                'stock'=> '50',
                'unit_measure'=> 'javas'
               
            ],
            [
                'name_article' => 'Hojas bond tamaño carta',
                'category_id' => $categorie1->id,
                'stock'=> '15',
                'unit_measure'=> 'Paquetes'      
            ],
            [
                'name_article' => 'Leche',
                'category_id'  => $categorie3->id,
                'stock'=> '100',
                'unit_measure'=> 'Litros'
            ],
            [
                'name_article' => 'Yogurt',
                'category_id' => $categorie4->id,
                'stock'=> '100',
                'unit_measure'=> 'Litros'
            ]
        ];
        foreach($articles as $key => $value){
            Article::create($value);
        }

    }
}
