<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = ['class_id', 'student_id', 'paid_status', 'staff_id', 'amount','description','session_year','name'];

    public function student()
    {
        return $this->belongsTo('App\Student', 'student_id');
    }
    public function classRoom()
    {
        return $this->belongsTo('App\Model\ClassRoom', 'class_id');
    }
    public function staff()
    {
        return $this->belongsTo('App\Staff', 'staff_id');
    }
    public function bill()
    {
        return $this->belongsToMany('App\Model\Bill', 'bill_discount','discount_id','bill_id');
    }
}
