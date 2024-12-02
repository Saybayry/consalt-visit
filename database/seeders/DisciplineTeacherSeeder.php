<?php

namespace Database\Seeders;

use App\Models\Discipline;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisciplineTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::all()->each(function ($teacher) {
            $count = rand(1, 5);

            $teacher->disciplines()->attach(
                Discipline::inRandomOrder()->limit($count)->pluck('id')->toArray()
            );
        });
    }
}
