<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'fname',
        'lname',
        'mname',
        'user_id'
    ];
    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class, 'teacher_discipline');
    }
    /** @use HasFactory<\Database\Factories\TeacherFactory> */
    use HasFactory;
}
