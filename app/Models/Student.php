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
}
