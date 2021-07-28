<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Output;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class OutputSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

        //php artisan db:seed --class=OutputSeeder
        //Por si quieren ejecutar solo el seeder de Incomes
        public function run(){

        $dates=['2021-08-01','2021-07-12','2021-07-23','2021-07-04','2021-08-22','2021-08-12'];
        $months = ['2017-01-01', '2021-12-01'];

            for ($i=0; $i < 50; $i++) {
                if($i < 20){
                    $output = Output::create([
                        'section_id' =>'1',
                        'receipt' => rand(300,1000),
                        'order_number' => rand(100,700),
                        'order_date' => $months[0],
                        'delivery_date' => Arr::random($dates),
                        'created_at' => Arr::random($dates),
                        'total' => rand(300000,900000)/100,
                        ]);
                    $this->addDetails($output);
                }else {
                    $output = Output::create([
                        'section_id' =>'2',
                        'receipt' => rand(300,1000),
                        'order_number' => rand(100,700),
                        'order_date' => $months[1],
                        'delivery_date' => Arr::random($dates),
                        'total' => rand(300000,900000)/100,
                        'created_at' => Arr::random($dates)
                    ]);
                    $this->addDetails($output);
                }
            }
        }

        public function addDetails($output){
            $articles=Article::inRandomOrder()->take(rand(1,3))->pluck('id');

            foreach($articles as $article){
                $output->articles()->attach($article,[
                                'quantity'=>rand(1,100),
                                'budget_output'=>rand(1000,6000)/100,
                                'total'=>rand(10000,20000)/100,
                            ]);
            }
        }

}
