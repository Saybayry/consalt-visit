<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class TeacherSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем пользователей для учителей
        $teacherUsers = User::factory(20)->create([
            'is_teacher'=> true
        ]);

        foreach ($teacherUsers as $user) {
            Teacher::factory()->create([
                'user_id' => $user->id,
            ]);
        }

    }
}
