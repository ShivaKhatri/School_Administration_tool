<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    protected $fillable = ['name', 'description'];

    /**
     * creating a relation ship between class room and section through the normalised table classroom_section
     */
    public function section()
    {
        return $this->belongsToMany('App\Model\Section', 'classroom_section', 'class_id', 'sec_id');
    }
    public function student()
    {
        return $this->belongsToMany('App\Student', 'class_section_student', 'class_id', 'student_id');
    }

    public function subject()
    {
        return $this->belongsToMany('App\Model\Subject', 'classroom_subject', 'class_id', 'sub_id');
    }

    public function exam()
    {
        return $this->belongsToMany('App\Model\Exam', 'class_exam_sub', 'class_id', 'exam_id');
    }


}
