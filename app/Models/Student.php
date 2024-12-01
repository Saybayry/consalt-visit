<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['fname', 'lname', 'mname', 'group_id'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;
}
