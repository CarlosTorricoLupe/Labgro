<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        $super_admin = Role::where('name','Super_Admin')->first();
        $super_admin ->permissions()->sync([1,2,3]);

        $users = Role::where('name','Almacenes')->first();
        $users ->permissions()->sync([2,3]);

        $viewers = Role::where('name','Almacenes')->first();
        $viewers ->permissions()->sync([3]);


    }
}
