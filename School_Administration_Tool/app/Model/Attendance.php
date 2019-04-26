<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['class_id', 'section_id', 'exam_id', 'date', 'staff_id', 'session'];

    /**
     * creating a relation ship between class room and section through the normalised table classroom_section
     */
    public function classRoom()
    {
        return $this->belongsTo('App\Model\ClassRoom', 'class_id');
    }
    public function section()
    {
        return $this->belongsTo('App\Model\Section', 'section_id');
    }
    public function exam()
    {
        return $this->belongsTo('App\Model\Exam', 'exam_id');
    }
    public function staff()
    {
        return $this->belongsTo('App\Model\Staff', 'staff_id');
    }
    public function student()
    {
        return $this->belongsToMany('App\Student', 'attendance_student', 'attendance_id', 'student_id');
    }

}
