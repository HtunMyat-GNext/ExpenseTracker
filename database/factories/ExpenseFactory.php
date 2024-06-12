<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Days;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $day = rand(1, 28);
        return [
            'user_id' => '1',
            'name' => $this->faker->words(3, true),
            'amount' => $this->faker->numberBetween(10, 1000),
            'category_id' => $this->faker->numberBetween(1, 5),
            'date' => '2024/6' . '/' . $day,
        ];
    }
}
