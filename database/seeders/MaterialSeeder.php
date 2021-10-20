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
            //jugo
            [
                'code' => 'Pulp',
                'stock_start' => '100',
                'stock_min' => '10',
                'color' => '#FFFFFF',
                'article_id' => 1,
                'is_a' =>'supplies',
                'role_id'=>2               
            ],
            [
                'code' => 'Acid',
                'stock_start' => '50',
                'stock_min' => '10',
                'color' => '#FFFFFF',
                'article_id' => 2,
                'is_a' =>'raw_material',
                'role_id'=>5
            ],
            [
                'code' => 'Azcr',
                'stock_start' => '100',
                'stock_min' => '10',
                'article_id' => 3,
                'is_a' =>'supplies',
                'role_id'=>5
            ],
            [
                'code' => 'Cnsvt',
                'stock_start' => '150',
                'stock_min' => '10',
                'article_id' => 4,
                'is_a' =>'raw_material',
                'role_id'=>2
            ],
            //queso
            [
                'code' => 'Cuj',
                'stock_start' => '80',
                'stock_min' => '10',
                'color' => '#FFFFFF',
                'article_id' => 5,
                'is_a' =>'raw_material',
                'role_id'=>2
            ],
            [
                'code' => 'CujYi',
                'stock_start' => '70',
                'stock_min' => '10',
                'color' => '#FFFFFF',
                'article_id' => 6,
                'is_a' =>'raw_material',
                'role_id'=>5
            ],
            [
                'code' => 'SalNue',
                'stock_start' => '120',
                'stock_min' => '10',
                'color' => '#FFFFFF',
                'article_id' => 7,
                'is_a' =>'raw_material',
                'role_id'=>4
            ],
            [
                'code' => 'CloCal',
                'stock_start' => '110',
                'stock_min' => '10',
                'color' => '#FFFFFF',
                'article_id' => 8,
                'is_a' =>'raw_material',
                'role_id'=>5
            ],
            [
                'code' => 'Ferm',
                'stock_start' => '100',
                'stock_min' => '10',
                'color' => '#FFFFFF',
                'article_id' => 9,
                'is_a' =>'raw_material',
                'role_id'=>3
            ],
        ];
        foreach($materials as $key => $value){
            Material::create($value);
        }
    }
}
