<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Генерация случайного названия группы
        $year = $this->faker->numberBetween(100, 299); // Префикс года (например, 205)
        $suffix = $this->faker->regexify('[a-z]{1}[0-9]-[0-9]'); // S11-5
        $name = "{$year}{$suffix}";

        return [
            'name' => $name,
            'year_graduation' => $this->faker->numberBetween(2020, 2030), // Случайный год выпуска
        ];

    }
}
