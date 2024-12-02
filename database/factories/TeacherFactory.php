<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('ru_RU');
        $fullName = $faker->name; // Генерация полного имени
        $nameParts = explode(' ', $fullName);

        return [
            'fname' =>  $nameParts[0], // Генерирует имя
            'lname' =>  $nameParts[2],   // Генерирует фамилию
            'mname' =>  $nameParts[1], // Генерирует отчество (доступно в локали ru_RU)
        ];
    }
}
