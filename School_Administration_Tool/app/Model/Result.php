<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['class_id', 'sec_id', 'exam_id', 'obtained_mark', 'total_mark', 'session','grade','gradeDescription','mark_id','student_id','published'];

    public function classRoom()
    {
        return $this->belongsTo('App\Model\ClassRoom', 'class_id');
    }
    public function student()
    {
        return $this->belongsTo('App\Student', 'student_id');
    }
    public function section()
    {
        return $this->belongsTo('App\Model\Section', 'sec_id');
    }
    public function exam()
    {
        return $this->belongsTo('App\Model\Exam', 'exam_id');
    }
    public function mark()
    {
        return $this->belongsTo('App\Model\Mark', 'mark_id');
    }
}
