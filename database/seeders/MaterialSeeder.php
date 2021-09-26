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
                'code' => 'Pulp',
                'stock_start' => '20',
                'stock_min' => '10',
                'color' => '#FFFFFF',
                'article_id' => 1,
                'is_a' =>'raw_material'
            ],
            [
                'code' => 'Acid',
                'stock_start' => '20',
                'stock_min' => '10',
                'color' => '#FFFFFF',
                'article_id' => 2,
                'is_a' =>'raw_material'
            ],
            [
                'code' => 'Azcr',
                'stock_start' => '20',
                'stock_min' => '10',
                'article_id' => 3,
                'is_a' =>'supplies'
            ],
            [
                'code' => 'Cnsvt',
                'stock_start' => '20',
                'stock_min' => '10',
                'article_id' => 4,
                'is_a' =>'supplies'
            ]
        ];
        foreach($materials as $key => $value){
            Material::create($value);
        }
    }
}
