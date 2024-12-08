<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /** @use HasFactory<\Database\Factories\GroupFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'year_graduation'
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function consultations()
    {
        return $this->belongsToMany(Consultation::class, 'consultation_group')
                    ->withTimestamps(); // Если нужно учитывать время создания связи
    }
}
