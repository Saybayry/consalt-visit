<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consultation>
 */
class ConsultationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {


        // Schema::create('consultations', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        //     $table->foreignId('teacher_id')->nullable()->constrained('teachers')->onDelete('cascade');
        //     $table->foreignId('discipline_id')->nullable()->constrained('disciplines')->onDelete('cascade');
        //     $table->date('class_date'); 
        //     $table->unsignedTinyInteger('class_number'); 
        // });

        $teacher = Teacher::inRandomOrder()->first();
        $discipline = $teacher->disciplines()->inRandomOrder()->first();

        return [
            'teacher_id'=>$teacher->id,
            'discipline_id'=>$discipline->id,
            'class_date' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'class_number'=>fake()->numberBetween(1,8),
        ];
    }
}
