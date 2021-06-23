<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
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
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
