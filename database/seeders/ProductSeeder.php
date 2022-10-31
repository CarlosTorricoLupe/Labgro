<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\PresentationUnit;
use App\Models\Product;
use App\Models\Unit;
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
        /*
        $name=['Gelatina','Yogurt','Jugo', 'Queso'];
        $cod=['Gel12','Yog','Jug', 'Ques'];
        $descr = ['Gelatina elaborada en la Facultad de Agronomía',
            'Yogurt elaborada en la Facultad de Agronomía',
            'Jugo elaborada en la Facultad de Agronomía',
            'Queso elaborada en la Facultad de Agronomía',];
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
*/
        $ltr = Unit::where('unit_measure','Ltr')->first();
        $jug=Product::create([
            'name' => 'Jugo',
            'code'=> 'Jug',
            'description' => 'Jugo elaborada en la Facultad de Agronomía',
            'role_id'=>5,
            'image'=> 'https://picsum.photos/700/400?random',
            'unit_id'=>$ltr->id
        ]);
        $jug->ingredients()->attach(1,['quantity'=>0.1]);
        $jug->ingredients()->attach(2,['quantity'=>0.09]);
        $jug->ingredients()->attach(3,['quantity'=>0.666666]);
        $jug->ingredients()->attach(4,['quantity'=>0.25]);

        // $ques=Product::create([
        //     'name' => 'Queso',
        //     'code'=> 'Ques',
        //     'description' => 'Queso elaborada en la Facultad de Agronomía',
        //     'role_id'=>2,
        //     'image'=> 'https://picsum.photos/700/400?random',
        // ]);
        // $ques->ingredients()->attach(5,['quantity'=>0.4]);
        // $ques->ingredients()->attach(6,['quantity'=>0.3]);
        // $ques->ingredients()->attach(7,['quantity'=>0.666666]);
        // $ques->ingredients()->attach(8,['quantity'=>17.8]);
        // $ques->ingredients()->attach(9,['quantity'=>2.5]);
    }
}
