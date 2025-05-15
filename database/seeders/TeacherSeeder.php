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

                // 🔹 1. Создаем конкретного учителя-админа с заданными данными
        $adminUser = User::create([
            'name' => 'Admin Teacher',
            'email' => 'admin.teacher@example.com',
            'password' => bcrypt('password'), // Используй хеширование!
            'is_teacher' => true,
            'is_admin' => true,
        ]);

        Teacher::create([
            'user_id' => $adminUser->id,
            'fname' => 'Иван',
            'lname' => 'Иванов',
            'mname' => 'Иванович',
        ]);

        // 🔹 2. Генерация остальных учителей
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
