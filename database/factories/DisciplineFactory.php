<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discipline>
 */
class DisciplineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     private function generateSubjectName()
     {
         $prefixes = [
             '', 'Основы', 'Технология', 'Обеспечение', 'Управление', 
             'Правовое обеспечение', 'Поддержка', 'Разработка', 
             'Системное', 'Архитектура', 'Инструментальные средства',
             'Моделирование', 'Проектирование', 'Методы', 
             'Анализ', 'Оптимизация', 'Программирование', 
             'Теория'
         ];
     
         $focusAreas = [
             'функционирования компьютерных систем', 
             'разработки и защиты баз данных', 
             'веб-разработки', 
             'алгоритмизации и программирования', 
             'математической статистики', 
             'проектирования программного обеспечения', 
             'моделирования', 
             'экономики отрасли', 
             'технического документоведения',
             'информационных технологий', 
             'вычислительных систем', 
             'цифровых коммуникаций',
             'систем искусственного интеллекта', 
             'мультимедийных технологий', 
             'кибербезопасности', 
             'системного анализа'
         ];
     
         $contexts = [
             '', 
             'в профессиональной деятельности', 
             'и технического анализа', 
             'для информационных технологий', 
             'и вычислительных систем', 
             'в управлении IT-проектами', 
             'в современном мире',
             'для интернета вещей', 
             'и их применение', 
             'в научных исследованиях', 
             'в образовательных системах', 
             'в условиях цифровой трансформации'
         ];
     
         // Выбираем случайные элементы
         $prefix = $prefixes[array_rand($prefixes)];
         $focusArea = $focusAreas[array_rand($focusAreas)];
         $context = $contexts[array_rand($contexts)];
     
         // Комбинируем
         return trim("$prefix $focusArea $context");
     }
 
     /**
      * Define the model's default state.
      *
      * @return array<string, mixed>
      */
     public function definition(): array
     {
         return [
             'name' => $this->generateSubjectName(),
         ];
     }
}
