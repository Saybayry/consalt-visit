<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'teacher_id',
        'discipline_id',
        'class_date',
        'class_number',
    ];

    public function registrationForStudent($studentId)
    {
        return $this->hasOne(ConsultationRegistration::class)
            ->where('student_id', $studentId);
    }
    public function registrations()
    {
        return $this->hasMany(\App\Models\ConsultationRegistration::class);
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'visitings')
                    ->withPivot('is_present')
                    ->withTimestamps();
    }

    /** @use HasFactory<\Database\Factories\ConsultationsFactory> */
    public function groups()
{
    return $this->belongsToMany(Group::class, 'consultation_group')
                ->withTimestamps(); // Если нужно учитывать время создания связи
}

public function attachGroupWithStudents($groupId)
{
    // Связать группу с консультацией
    $this->groups()->attach($groupId);

    // Найти всех студентов этой группы
    $students = Student::where('group_id', $groupId)->get();

    // Создать записи в таблице visitings
    foreach ($students as $student) {
        $this->students()->attach($student->id, ['is_present' => false]);
    }
}
    use HasFactory; 
}
