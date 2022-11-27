<?php

namespace Database\Factories;

use App\Models\Income;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

class IncomeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Income::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'receipt' => $this->faker->randomNumber(),
            'provider' => $this->faker->word(),
            'order_number' => $this->faker->randomNumber(),
            // 'user_id' => auth()->user()->role_id,
            'total' => $this->faker->randomNumber(3,true),
            'invoice_number' => $this->faker->randomNumber(),
            'created_at'=>$this->faker->date(),
        ];
    }
}
