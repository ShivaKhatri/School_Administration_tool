<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    protected $fillable = ['token', 'staff_id', 'guardian_id', 'student_id'];

    /**
     * creating a relation ship between class room and section through the normalised table classroom_section
     */


}
