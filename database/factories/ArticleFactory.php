<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        Unit::factory()->count(3)->create();
        Category::factory()->count(3)->create();
        return [
            'name_article' => $this->faker->word(),
            'cod_article' => $this->faker->unique()->word(),
            'unit_price' => $this->faker->randomFloat(2),
            'stock' => $this->faker->randomNumber(3,false),
            'unit_id' => rand(1,3),
            'category_id' => rand(1,3),
            'stock_min' => $this->faker->randomNumber(2,true)
        ];
    }
}
