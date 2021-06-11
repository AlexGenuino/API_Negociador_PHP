<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $table = 'debt';

    protected $fillable = [
        'parcel', 'form_payment', 'value', 'payment', 'expiration_date'
    ];

    public function student()
    {
        return $this->belongsToMany(Student::class, 'student_debt');
    }
}
