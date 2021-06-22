<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'name' => 'Super_Admin' 
            ],           
            
            [
                'name' => 'Lacteos'
            ],
            
            [
                'name' => 'Frutas'
            ],

            [
                'name' => 'Carnicos'
            ],

            [
                'name' => 'Almacenes'
            ]

        ];

        foreach ($items as $key => $value) {
            Role::create($value);
        }

    }
}
