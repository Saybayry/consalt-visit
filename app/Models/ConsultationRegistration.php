<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsultationRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'consultation_id',
        'is_present',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    
}