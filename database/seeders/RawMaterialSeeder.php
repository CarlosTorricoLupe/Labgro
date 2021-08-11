<?php

namespace Database\Seeders;

use App\Models\RawMaterial;
use Illuminate\Database\Seeder;

class RawMaterialSeeder extends Seeder
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
                'code' => 'COD123',
                'stock_start' => '20',
                'stock_min' => '10',
                'color' => '#FFFFFF',
                'article_id' => 1,
            ],
            [
                'code' => 'COD124',
                'stock_start' => '20',
                'stock_min' => '10',
                'color' => '#FFFFFF',
                'article_id' => 1,

            ],
            [
                'code' => 'COD125',
                'stock_start' => '20',
                'stock_min' => '10',
                'article_id' => 2,

            ],
            [
                'code' => 'COD126',
                'stock_start' => '20',
                'stock_min' => '10',
                'article_id' => 3,

            ]
        ];
        foreach($categories as $key => $value){
            RawMaterial::create($value);
        }
    }
}
