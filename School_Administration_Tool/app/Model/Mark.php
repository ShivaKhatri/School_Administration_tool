<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $fillable = ['class_id', 'sec_id', 'exam_id', 'date', 'staff_id', 'session','result'];

    public function student()
    {
        return $this->belongsToMany('App\Student', 'mark_student', 'mark_id', 'student_id');
    }
    public function classRoom()
    {
        return $this->belongsTo('App\Model\ClassRoom', 'class_id');
    }
    public function subject()
    {
        return $this->belongsTo('App\Model\Subject', 'sub_id');
    }
    public function section()
    {
        return $this->belongsTo('App\Model\Section', 'sec_id');
    }
    public function exam()
    {
        return $this->belongsTo('App\Model\Exam', 'exam_id');
    }
    public function staff()
    {
        return $this->belongsTo('App\Model\Staff', 'staff_id');
    }
}
