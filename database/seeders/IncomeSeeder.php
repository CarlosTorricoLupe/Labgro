<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Income;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

     //php artisan db:seed --class=IncomeSeeder 
     //Por si quieren ejecutar solo el seeder de Incomes
    public function run()
    {      
        $dates=['2021-08-01','2021-07-12','2021-07-23','2021-07-04','2021-08-22','2021-08-12'];

        for ($i=0; $i < 5; $i++) { 
            $incom=Income::create([
                'receipt' => rand(300,1000),
                'total' => rand(300000,900000)/100,
                'provider' => 'pedro',
                'order_number' => rand(100,700),
                'created_at' => Arr::random($dates),
                'invoice_number'=>rand(100,1000)]);

                $articles=Article::inRandomOrder()->take(rand(1,3))->pluck('id');
                foreach($articles as $article){
                    $incom->articles()->attach($article,['quantity'=>rand(1,100),'unit_price'=>rand(1000,6000)/100,'total_price'=>rand(10000,20000)/100]);
                }
        }
    }
    
}
