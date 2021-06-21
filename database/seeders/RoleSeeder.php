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
                'name' => 'super_admin' 
            ],           
            [
                'name' => 'users',
            ],
            [
                'name' => 'viewers',
            ]

        ];

        foreach ($items as $key => $value) {
            Role::create($value);
        }

    }
}
