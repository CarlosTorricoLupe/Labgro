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

        $unit = Unit::where('unit_measure','Unidad')->first();
        $kg = Unit::where('unit_measure','Kg')->first();
        $ltr = Unit::where('unit_measure','Ltr')->first();
        $caja = Unit::where('unit_measure','Caja')->first();
        $sobre = Unit::where('unit_measure','Sobres')->first();

        $articles= [
            //Jugos
            [
                'cod_article' => 'Plp',
                'name_article' => 'Pulpa',
                'category_id' => $categorie4->id,
                'stock'=> '200',
                'unit_price'=>40,
                'stock_total'=>'50',
                'unit_id'=> $kg->id,

            ],
            [
                'cod_article' => 'AcdNit',
                'name_article' => 'Acido Nitrico',
                'category_id' => $categorie3->id,
                'stock'=> '100',
                'unit_price'=>50,
                'stock_total'=>'15',
                'unit_id'=> $kg->id,
            ],
            [
                'cod_article' => 'Azc',
                'name_article' => 'Azucar',
                'category_id'  => $categorie4->id,
                'stock'=> '100',
                'unit_price'=>70,
                'stock_total'=>'100',
                'unit_id'=> $kg->id,
            ],
            [
                'cod_article' => 'Consv',
                'name_article' => 'Conservante',
                'category_id' => $categorie3->id,
                'stock'=> '100',
                'unit_price'=>60,
                'stock_total'=>'100',
                'unit_id'=> $kg->id,
            ],
            //Queso --5
            [
                'cod_article' => 'Cuj',
                'name_article' => 'Cuajo',
                'category_id' => $categorie3->id,
                'stock'=> '100',
                'unit_price'=>20,
                'stock_total'=>'100',
                'unit_id'=> $sobre->id,
            ],
            [
                'cod_article' => 'CujYi',
                'name_article' => 'Cuajo Yimax',
                'category_id' => $categorie3->id,
                'stock'=> '150',
                'unit_price'=>10,
                'stock_total'=>'90',
                'unit_id'=> $kg->id,
            ],
            [
                'cod_article' => 'SalNue',
                'name_article' => 'Sal Nuevo',
                'category_id' => $categorie3->id,
                'stock'=> '150',
                'unit_price'=>10,
                'stock_total'=>'90',
                'unit_id'=> $kg->id,
            ],
            [
                'cod_article' => 'CloCal',
                'name_article' => 'Cloruro de Calcio',
                'category_id' => $categorie3->id,
                'stock'=> '130',
                'unit_price'=>5,
                'stock_total'=>'80',
                'unit_id'=> $kg->id,
            ],
            [
                'cod_article' => 'Ferm',
                'name_article' => 'Fermento',
                'category_id' => $categorie3->id,
                'stock'=> '120',
                'unit_price'=>5,
                'stock_total'=>'80',
                'unit_id'=> $kg->id,
            ],

        ];
        foreach($articles as $key => $value){
            Article::create($value);
        }

    }
}
