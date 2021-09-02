<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materials = [
            [
                'code' => 'COD123',
                'stock_start' => '20',
                'stock_min' => '10',
                'color' => '#FFFFFF',
                'article_id' => 1,
                'is_a' =>'raw_material'
            ],
            [
                'code' => 'COD124',
                'stock_start' => '20',
                'stock_min' => '10',
                'color' => '#FFFFFF',
                'article_id' => 1,
                'is_a' =>'raw_material'
            ],
            [
                'code' => 'COD125',
                'stock_start' => '20',
                'stock_min' => '10',
                'article_id' => 2,
                'is_a' =>'supplies'
            ],
            [
                'code' => 'COD126',
                'stock_start' => '20',
                'stock_min' => '10',
                'article_id' => 3,
                'is_a' =>'supplies'
            ]
        ];
        foreach($materials as $key => $value){
            Material::create($value);
        }
    }
}
