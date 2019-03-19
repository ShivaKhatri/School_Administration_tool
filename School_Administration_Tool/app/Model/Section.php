<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['name', 'description'];

    /**
     * creating a relation ship between class room and section through the normalised table classroom_section
     */
    public function classRoom()
    {
        return $this->belongsToMany('App\Model\ClassRoom', 'classroom_section', 'sec_id', 'class_id');
    }


}
