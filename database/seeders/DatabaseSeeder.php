<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'Admin@example.com',
            'password'=>Hash::make('password'),
            'is_admin'=>true,
        ]);
        $this->call([
            GroupSeeder::class,
            StudentSeeder::class,
            DisciplineSeeder::class,
            TeacherSeeder::class,
            DisciplineTeacherSeeder::class,
            ConsultationsSeeder::class,
            AddGroupsToConsultationsSeeder::class,
        ]);



    }
}
