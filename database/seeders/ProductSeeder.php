<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\PresentationUnit;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name=['Gelatina','Yogurt','Jugo'];
        $cod=['Gel12','Yog','Jug'];
        $descr=['Desc1','Desc2','Desc3'];
        $roles=[4,2,5];

        for ($i=0; $i <2 ; $i++) { 
            $prd=Product::create([
                'name' => Arr::get($name,$i),
                'code'=> Arr::get($cod,$i),
                'description' => Arr::get($descr,$i),
                'role_id'=>Arr::get($roles,$i),
                'image'=> 'https://picsum.photos/700/400?random',
            ]);
            $presentations=PresentationUnit::inRandomOrder()->take(rand(1,3))->pluck('id');
            foreach($presentations as $pres){
                $prd->presentations()->attach($pres,['unit_cost_production'=>rand(1,100),'unit_price_sale'=>rand(1000,6000)/100]);
            }
            $materials=Material::inRandomOrder()->take(rand(1,3))->pluck('id');
            foreach($materials as $mat){
                $prd->ingredients()->attach($mat,['quantity'=>rand(1,100)]);
            }
        }

        $jug=Product::create([
            'name' => Arr::get($name,2),
            'code'=> Arr::get($cod,2),
            'description' => Arr::get($descr,2),
            'role_id'=>Arr::get($roles,2),
            'image'=> 'https://picsum.photos/700/400?random',
        ]);
        $jug->ingredients()->attach(1,['quantity'=>0.1]);
        $jug->ingredients()->attach(2,['quantity'=>0.09]);
        $jug->ingredients()->attach(3,['quantity'=>0.666666]);
        $jug->ingredients()->attach(4,['quantity'=>0.25]);
    }
}
