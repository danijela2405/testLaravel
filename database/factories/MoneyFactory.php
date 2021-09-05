<?php

namespace Database\Factories;

use App\Models\Money;
use Illuminate\Database\Eloquent\Factories\Factory;

class MoneyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Money::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'currency' => $this->faker->currencyCode(),
            'value' => $this->faker->numberBetween(100, 600),
        ];
    }
}
