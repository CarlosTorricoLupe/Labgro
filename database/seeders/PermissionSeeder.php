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
                'name' => 'ver_articulos' 
            ],           
            [
                'name' => 'administrar_articulos',
            ],
            [
                'name' => 'administrar_usuarios',
            ]

        ];

        foreach ($items as $key => $value) {
            Permission::create($value);
        }
    }
}
