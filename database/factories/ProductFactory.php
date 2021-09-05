<?php

namespace Database\Factories;

use App\Models\Money;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'quantity' => $this->faker->numberBetween(100,200),
            'price_id' => Money::factory()->create()->id,
            'store_id' => 1
        ];
    }
}
