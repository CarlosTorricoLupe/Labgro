<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;


class PermissionSeeder extends Seeder
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
                'name' => 'views_articles' 
            ],           
            [
                'name' => 'manage_articles',
            ],
            [
                'name' => 'manage_users',
            ]

        ];

        foreach ($items as $key => $value) {
            Permission::create($value);
        }
    }
}
