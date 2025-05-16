<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'fname', 
        'lname', 
        'mname', 
        'group_id',
        'user_id'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function consultation_registrations()
    {
        return $this->belongsToMany(Consultation::class, 'consultation_registrations')
                    ->withPivot('is_present') // Поле для отметки присутствия
                    ->withTimestamps();
    }
    public function consultationRegistrations()
    {
        return $this->hasMany(ConsultationRegistration::class);
    }

    // Связь с моделью User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;
}
