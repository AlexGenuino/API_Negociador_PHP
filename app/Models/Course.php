<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    protected $table = 'course';

    protected $fillable = [
        'name', 'time_course', 'semester', 'value_semester'
    ];

    public function student()
    {
        return $this->belongsToMany(Student::class, 'student_course');
    }
}
