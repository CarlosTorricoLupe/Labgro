<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Output;
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
             RoleSeeder::class,
             PermissionSeeder::class,
             RolePermissionSeeder::class,
             UserSeeder::class,
             ArticleSeeder::class,
             SectionSeeder::class,
             IncomeSeeder::class,
             //OutputSeeder::class,
             MaterialSeeder::class,
             PresentationUnitsSeeder::class,
             //ProductSeeder::class,
         ]);
        //\App\Models\User::factory()->create();
    }
}
