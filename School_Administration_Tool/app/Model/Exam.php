<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['name', 'description', 'status', 'from', 'to','resultDay','session_year'];
    protected $from = ['from'];
    protected $to = ['to'];
    protected $session_year = ['session_year'];

    /**
     * creating a relation ship between class room and section through the normalised table classroom_section
     */

    public function subject()
    {
        return $this->belongsToMany('App\Model\Subject', 'class_exam_sub', 'exam_id', 'sub_id');
    }
    public function attendance()
    {
        return $this->hasMany('App\Model\Attendance', 'exam_id');
    }

    public function classRoom()
    {
        return $this->belongsToMany('App\Model\ClassRoom', 'class_exam_sub', 'exam_id', 'class_id');
    }
}
