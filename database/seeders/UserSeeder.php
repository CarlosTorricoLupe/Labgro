<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users= [
            [
                'name' => 'SuperAdmin',
                'email' => 'superadmin@gmail.com',
                'email_verified_at' => Null,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Null,
                'role_id' =>1
               
            ],
            [
                'name' => 'Lacteos',
                'email' => 'lacteos@gmail.com',
                'email_verified_at' => Null,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Null,
                'role_id' =>2 
            ],
            [
                'name' => 'Frutas',
                'email' => 'frutas@gmail.com',
                'email_verified_at' => Null,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Null,
                'role_id' =>3
            ],
            [
                'name' => 'Carnicos',
                'email' => 'carnicos@gmail.com',
                'email_verified_at' => Null,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Null,
                'role_id' =>4
            ],
            [
                'name' => 'Almacen',
                'email' => 'almacen@gmail.com',
                'email_verified_at' => Null,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Null,
                'role_id' =>5
            ]
        ];
        foreach($users as $key => $value){
            User::create($value);
        }
    }
}
