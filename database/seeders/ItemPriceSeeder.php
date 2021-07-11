<?php

namespace Database\Seeders;

use App\Models\ItemPrice;
use Illuminate\Database\Seeder;

class ItemPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item_prices= [
            [
                'unit_price' => '85'
            ],
            [
                'unit_price' => '50'
            ],
            [
                'unit_price' => '20'
            ],
            [
                'unit_price' => '10'
            ]
        ];
        foreach($item_prices as $key => $value){
            ItemPrice::create($value);
        }
    }
}
