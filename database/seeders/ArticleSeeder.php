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

        $units1 = Unit::where('unit_measure','Unidad')->orWhere('kind','Otro')->pluck('id');
        $units2 = Unit::where('unit_measure','Kg')->orWhere('kind','Peso')->pluck('id');
        $units3 = Unit::where('unit_measure','Ltr')->orWhere('kind','Volumen')->pluck('id');
        $units4 = Unit::where('unit_measure','Caja')->orWhere('kind','Otro')->pluck('id');

        $articles= [
            [
                'cod_article' => 'Plp',
                'name_article' => 'Pulpa',
                'category_id' => $categorie2->id,
                'stock'=> '50',
                'unit_price'=>40,
                'stock_total'=>'50',
                'unit_id'=> $units2[0]

            ],
            [
                'cod_article' => 'AcdNit',
                'name_article' => 'Acido Nitrico',
                'category_id' => $categorie1->id,
                'stock'=> '15',
                'unit_price'=>50,
                'stock_total'=>'15',
                'unit_id'=> $units2[0]
            ],
            [
                'cod_article' => 'Azc',
                'name_article' => 'Azucar',
                'category_id'  => $categorie3->id,
                'stock'=> '100',
                'unit_price'=>70,
                'stock_total'=>'100',
                'unit_id'=> $units1[0]
            ],
            [
                'cod_article' => 'Consv',
                'name_article' => 'Conservante',
                'category_id' => $categorie4->id,
                'stock'=> '100',
                'unit_price'=>60,
                'stock_total'=>'100',
                'unit_id'=> $units1[0]
            ]
        ];
        foreach($articles as $key => $value){
            Article::create($value);
        }

    }
}
