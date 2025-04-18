<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    protected $fillable = [
        'name'
    ];
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_discipline');

    }    
    use HasFactory;
}
