<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['course_name', 'course_description'];
    protected $table = 'courses';
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_course', 'course_id', 'student_id')
                    ->withPivot('additional_info')
                    ->withTimestamps();
    }
}
