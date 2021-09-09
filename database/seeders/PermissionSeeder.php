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
            //ALMACEN
            [
                'name' => 'view_articles'
            ],
            [
                'name' => 'manage_articles'
            ],
            [
                'name' => 'view_categories'
            ],
            [
                'name' => 'manage_categories'
            ],
        ];

        foreach ($items as $key => $value) {
            Permission::create($value);
        }
    }
}
