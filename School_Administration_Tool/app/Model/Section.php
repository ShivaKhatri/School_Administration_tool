<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['name', 'description'];

    /**
     * creating a relation ship between class room and section through the normalised table classroom_section
     */
    public function roles()
    {
        return $this->belongsToMany('App\Model\Section');
    }
}
