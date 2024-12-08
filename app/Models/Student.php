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
        'group_id'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function consultations()
    {
        return $this->belongsToMany(Consultation::class, 'visitings')
                    ->withPivot('is_present') // Поле для отметки присутствия
                    ->withTimestamps();
    }
        /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;
}
