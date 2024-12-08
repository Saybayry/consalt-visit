<?php

namespace Database\Seeders;

use App\Models\Consultation;
use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddGroupsToConsultationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // Получить все консультации
        $consultations = Consultation::all();

        // Получить все группы
        $groups = Group::all();

        // Для каждой консультации случайно назначить несколько групп
        foreach ($consultations as $consultation) {
            // Случайное количество групп (например, от 1 до 3)
            $randomGroups = $groups->random(rand(1, 3));

            // Привязать группы к консультации
            foreach ($randomGroups as $group) {
                $consultation->groups()->attach($group->id);

                // Добавить студентов группы в таблицу visitings
                foreach ($group->students as $student) {
                    $consultation->students()->attach($student->id, ['is_present' => false]);
                }
            }
        }
    }
}
