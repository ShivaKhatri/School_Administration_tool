<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'description'];

    /**
     * creating a relation ship between class room and section through the normalised table classroom_section
     */
    public function classRoom()
    {
        return $this->belongsToMany('App\Model\ClassRoom', 'classroom_subject', 'sub_id', 'class_id');
    }

    public function exam()
    {
        return $this->belongsToMany('App\Model\Exam', 'class_exam_sub', 'sub_id', 'exam_id');
    }

}
