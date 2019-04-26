<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AttendanceStudent extends Model
{
    protected $fillable = ['student_id', 'attendance_id', 'sub_id', 'present'];

}
