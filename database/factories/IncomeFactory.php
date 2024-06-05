<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Income>
 */
class IncomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => '1',
            'title' => $this->faker->words(3, true),
            'amount' => $this->faker->numberBetween(100, 5000),
            'category_id' => $this->faker->numberBetween(2, 4),
            'image' => $this->faker->imageUrl(640, 480, 'finance'),
            'date' => $this->faker->date(),
        ];
    }
}
