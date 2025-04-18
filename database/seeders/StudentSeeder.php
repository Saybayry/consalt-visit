<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем пользователей для студентов
        $studentUsers = User::factory(100)->create();

        foreach ($studentUsers as $user) {
            Student::factory()->create([
                'user_id' => $user->id,
            ]);
        }

    }
}
