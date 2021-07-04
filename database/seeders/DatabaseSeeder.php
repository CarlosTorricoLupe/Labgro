<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
     //    \App\Models\User::factory()->create();


         $this->call([
             UnitSeeder::class,
             CategorySeeder::class,
             //ArticleSeeder::class,
             RoleSeeder::class,
             PermissionSeeder::class,
             RolePermissionSeeder::class,
             UserSeeder::class
         ]);
        //\App\Models\User::factory()->create();
    }
}
