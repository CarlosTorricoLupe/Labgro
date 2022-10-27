<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Income;
use App\Models\Output;
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
        $articles=Article::all()->pluck('id');

        $income=Income::create([
            "receipt" => 100,
            "total" =>  100.00,
            "provider" =>  "Jugos s.r.l",
            "order_number" =>  200,
            "created_at" =>  "2022-09-03 10:30:12",
            "invoice_number" => 101]);
            $income->articles()->attach(1,['quantity'=>20,
                    'unit_price'=>5,
                    'total_price'=>100,
            ]);
            $article=Article::find(1)->update(['stock'=>20,'stock_total'=>20,'unit_price'=>5]);
            $output = Output::create([
                'section_id' =>'1',
                'receipt' => 500,
                'order_number' => 500,
                'order_date' => "2022-09-04 10:30:12",
                'delivery_date' => "2022-09-04 10:50:12",
                'total' => 25]);
                $output->articles()->attach(1,[
                    'quantity'=>5,
                    'budget_output'=>50,
                    'total'=>25,
                    'balance_stock' => 15,
                    'balance_price' => 75
                ]);
                $article=Article::find(1)->update(['stock'=>15,'stock_total'=>15]);
            $output = Output::create([
                'section_id' =>'3',
                'receipt' => 501,
                'order_number' => 501,
                'order_date' => "2022-09-10 10:30:12",
                'delivery_date' => "2022-09-10 12:50:12",
                'total' => 15]);
                $output->articles()->attach(1,[
                        'quantity'=>3,
                        'budget_output'=>50,
                        'total'=>15,
                        'balance_stock' => 12,
                        'balance_price' => 60
                    ]);
                $article=Article::find(1)->update(['stock'=>12,'stock_total'=>12]);
            $output = Output::create([
                'section_id' =>'1',
                'receipt' => 502,
                'order_number' => 502,
                'order_date' => "2022-09-22 10:30:12",
                'delivery_date' => "2022-09-22 12:50:12",
                'total' => 60]);
                $output->articles()->attach(1,[
                        'quantity'=>12,
                        'budget_output'=>50,
                        'total'=>60,
                        'balance_stock' => 0,
                        'balance_price' => 0
                    ]);
                $article=Article::find(1)->update(['stock'=>0,'stock_total'=>0]);
            $income=Income::create([
                "receipt" => 101,
                "total" =>  150.00,
                "provider" =>  "Jugos s.r.l",
                "order_number" =>  201,
                "created_at" =>  "2022-10-01 10:30:12",
                "invoice_number" => 102]);
                $income->articles()->attach(1,['quantity'=>30,
                        'unit_price'=>5,
                        'total_price'=>150,
                ]);
                $article=Article::find(1)->update(['stock'=>30,'stock_total'=>30,'unit_price'=>5]);

            $income2=Income::create([
                "receipt" => 201,
                "total" =>  250.00,
                "provider" =>  "CuajaMax",
                "order_number" =>  202,
                "created_at" =>  "2022-10-02 10:30:12",
                "invoice_number" => 201]);
                $income2->articles()->attach(5,['quantity'=>50,
                            'unit_price'=>5,
                            'total_price'=>250,
                ]);
                $article=Article::find(5)->update(['stock'=>50,'stock_total'=>50,'unit_price'=>5]);

            $output = Output::create([
                'section_id' =>'3',
                'receipt' => 503,
                'order_number' => 503,
                'order_date' => "2022-10-05 10:30:12",
                'delivery_date' => "2022-10-05 12:50:12",
                'total' => 50]);
                $output->articles()->attach(5,[
                        'quantity'=>10,
                        'budget_output'=>60,
                        'total'=>50,
                        'balance_stock' => 40,
                        'balance_price' =>200
                    ]);
                $article=Article::find(5)->update(['stock'=>40,'stock_total'=>40]);

            $output = Output::create([
                'section_id' =>'3',
                'receipt' => 504,
                'order_number' => 504,
                'order_date' => "2022-10-14 10:30:12",
                'delivery_date' => "2022-10-14 12:50:12",
                'total' => 75]);
                $output->articles()->attach(5,[
                        'quantity'=>15,
                        'budget_output'=>60,
                        'total'=>75,
                        'balance_stock' => 25,
                        'balance_price' => 125
                    ]);
                $article=Article::find(5)->update(['stock'=>25,'stock_total'=>25]);

            $output = Output::create([
                'section_id' =>'3',
                'receipt' => 505,
                'order_number' => 505,
                'order_date' => "2022-10-25 10:30:12",
                'delivery_date' => "2022-10-25 12:50:12",
                'total' => 75]);
                $output->articles()->attach(5,[
                        'quantity'=>15,
                        'budget_output'=>60,
                        'total'=>75,
                        'balance_stock' => 10,
                        'balance_price' => 50
                    ]);
                $article=Article::find(5)->update(['stock'=>10,'stock_total'=>10]);
                
            $output = Output::create([
                'section_id' =>'3',
                'receipt' => 506,
                'order_number' => 506,
                'order_date' => "2022-11-04 10:30:12",
                'delivery_date' => "2022-11-04 12:50:12",
                'total' => 50]);
                $output->articles()->attach(5,[
                        'quantity'=>10,
                        'budget_output'=>61,
                        'total'=>50,
                        'balance_stock' => 0,
                        'balance_price' => 0
                    ]);
                $article=Article::find(5)->update(['stock'=>0,'stock_total'=>0]);

        $income3=Income::create([
            "receipt" => 202,
            "total" =>  250.00,
            "provider" =>  "",
            "order_number" =>  203,
            "created_at" =>  "2022-10-10 10:30:12",
            "invoice_number" => 203]);
            $income2->articles()->attach(6,['quantity'=>25,
                        'unit_price'=>10,
                        'total_price'=>250,
            ]);
            $article=Article::find(6)->update(['stock'=>25,'stock_total'=>25,'unit_price'=>10]);
            
        // for ($i=0; $i < 3; $i++) {
        //     $incom=Income::create([
        //         'receipt' => rand(300,1000),
        //         'total' => rand(300000,900000)/100,
        //         'provider' => 'pedro',
        //         'order_number' => rand(100,700),
        //         'created_at' => Arr::random($dates),
        //         'invoice_number'=>rand(100,1000)]);

        //         $articles=Article::inRandomOrder()->take(rand(1,3))->pluck('id');
        //         foreach($articles as $article){
        //             $incom->articles()->attach($article,['quantity'=>rand(1,100),
        //                 'unit_price'=>rand(1000,6000)/100,
        //                 'total_price'=>rand(10000,20000)/100,
        //                 'current_stock' => rand(300,1000),
        //                 'last_output' => Arr::random($dates),

        //             ]);
        //         }
        // }
    }

}
