<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $table = 'student';

    protected $fillable = [
        'CPF', 'name', 'login', 'password', 'birth_date'
    ];

    public function course()
    {
        return $this->belongsToMany(Course::class, 'student_course');
    }

    public function debt()
    {
        return $this->belongsToMany(Debt::class, 'student_debt');
    }
}
